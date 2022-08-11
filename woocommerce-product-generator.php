<?php
/**
 * woocommerce-product-generator.php
 *
 * Copyright (c) 2014-2022 "kento" Karim Rahimpur www.itthinx.com
 *
 * This code is released under the GNU General Public License.
 * See COPYRIGHT.txt and LICENSE.txt.
 *
 * This code is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * This header and all notices must be kept intact.
 *
 * @author itthinx
 * @package woocommerce-product-generator
 * @since 1.0.0
 *
 * Plugin Name: WooCommerce Product Generator
 * Plugin URI: http://www.itthinx.com/
 * Description: A sample product generator for WooCommerce.
 * Version: 2.1.0
 * Author: itthinx
 * Author URI: http://www.itthinx.com
 * Donate-Link: http://www.itthinx.com
 * License: GPLv3
 * WC requires at least: 5.8
 * WC tested up to: 6.8
 */

define( 'WOOPROGEN_PLUGIN_VERSION', '2.1.0' );
define( 'WOOPROGEN_PLUGIN_DOMAIN', 'woocommerce-product-generator' );
define( 'WOOPROGEN_PLUGIN_URL', WP_PLUGIN_URL . '/woocommerce-product-generator' );

if ( !defined( 'WPG_LOG' ) ) {
	define( 'WPG_LOG', true );
}

/**
 * Product Generator.
 */
class WooCommerce_Product_Generator {

	const MAX_PER_RUN = 100;
	const DEFAULT_PER_RUN = 10;

	const USE_UNSPLASH = true;

	const IMAGE_WIDTH = 512;
	const IMAGE_HEIGHT = 512;

	const DEFAULT_LIMIT = 10000;

	const REQUIRED_WOO = '5.8';

	private static $default_titles = '';
	private static $default_contents = '';
	private static $default_categories = '';
	private static $default_attributes = '';

	/**
	 * Initialize hooks.
	 */
	public static function init() {

		add_action( 'init', array( __CLASS__, 'load_plugin_textdomain' ) );

		// Check we're running the required version of WC.
		if ( ! defined( 'WC_VERSION' ) || version_compare( WC_VERSION, SELF::REQUIRED_WOO, '<' ) ) {
			add_action( 'admin_notices', array( __CLASS__, 'min_woo_notice' ) );
			return false;
		}

		add_action( 'admin_menu', array( __CLASS__, 'admin_menu' ) );
		add_filter( 'plugin_action_links_'. plugin_basename( __FILE__ ), array( __CLASS__, 'admin_settings_link' ) );
		add_action( 'wp_ajax_product_generator', array( __CLASS__, 'wp_init' ) );
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Localization                                                                     */
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Make the plugin translation ready.
	 *
	 * Translations should be added in the WordPress language directory:
	 *      - WP_LANG_DIR/plugins/woocommerce-product-generator-LOCALE.mo
	 *
	 * @since  1.2.0
	 */
	public static function load_plugin_textdomain() {
		load_plugin_textdomain( 'woocommerce-product-generator' , false , dirname( plugin_basename( __FILE__ ) ) .  '/languages/' );
	}


	/**
	 * Displays a warning message if version check fails.
	 *
	 * @return string
	 */
	public static function min_woo_notice() {
	    echo '<div class="error"><p>' . sprintf( __( 'WooCommerce Product Generator requires at least WooCommerce %s in order to function. Please upgrade WooCommerce.', 'woocommerce-product-generator' ), self::REQUIRED_WOO ) . '</p></div>';
	}

	/*-----------------------------------------------------------------------------------*/
	/*  Admin                                                                     */
	/*-----------------------------------------------------------------------------------*/

	/**
	 * Add the Generator menu item.
	 */
	public static function admin_menu() {
		$page = add_submenu_page(
			'woocommerce',
			__( 'Product Generator', 'woocommerce-product-generator' ),
			__( 'Product Generator', 'woocommerce-product-generator' ),
			'manage_woocommerce',
			'product-generator',
			array( __CLASS__, 'generator' )
		);
		add_action( 'load-' . $page, array( __CLASS__, 'load' ) );
	}

	public static function load() {
		$suffix = ( defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG ) ? '' : '.min';
		wp_enqueue_script( 'product-generator', plugins_url( 'js/product-generator' . $suffix . '.js', __FILE__ ), array( 'jquery' ), WOOPROGEN_PLUGIN_VERSION, true );

		$l10n = array(
			'generating'       => __( 'Generating', 'woocommerce-product-generator' ),
			'total'            => __( 'Total Products: %d', 'woocommerce-product-generator' ),
			'running'          => __( 'Running', 'woocommerce-product-generator' ),
			'stopped'          => __( 'Stopped', 'woocommerce-product-generator' ),
			'limit_reached'    => __( 'Limit reached, increase it to generate more products' ),
			'generation_stats' => __( 'Generation Stats', 'woocommerce-product-generator' ),
			'stats_sum'        => __( '&#425: %d', 'woocommerce-product-generator' ),
			'stats_simple'     => __( 'Simple: %d', 'woocommerce-product-generator' ),
			'stats_variable'   => __( 'Variable: %d', 'woocommerce-product-generator' ),
			'stats_variations' => __( 'Variations: %d', 'woocommerce-product-generator' ),
			'stats_time'       => __( 'Time: %s seconds', 'woocommerce-product-generator' ),
			'stats_pps'        => __( 'Performance: %s Products per Second', 'woocommerce-product-generator' ),
			'ajax_url'         => admin_url( 'admin-ajax.php' ),
			'js_nonce'         => wp_create_nonce( 'product-generator-js' ),
			'limit'            => get_option( 'woocommerce-product-generator-limit', self::DEFAULT_LIMIT )
		);
		wp_localize_script( 'product-generator', 'WC_Product_Generator', $l10n );

		wp_enqueue_style( 'product-generator', plugins_url( 'css/product-generator.css', __FILE__ ), array(), WOOPROGEN_PLUGIN_VERSION );
	}

	/**
	 * Adds plugin links.
	 *
	 * @param array $links
	 * @param array $links with additional links
	 */
	public static function admin_settings_link( $links ) {
		$links[] = '<a href="' . get_admin_url( null, 'admin.php?page=product-generator' ) . '">' . __( 'Product Generator', 'woocommerce-product-generator' ) . '</a>';
		return $links;
	}

	/**
	 * AJAX request handler.
	 *
	 * If a valid product generator request is recognized,
	 * it runs a generation cycle and then produces the JSON-encoded response
	 * containing the current number of published products held in the 'total'
	 * property.
	 */
	public static function wp_init() {
		if ( wp_verify_nonce( $_POST['nonce'], 'product-generator-js' ) ) {
			// run generator
			$per_run = get_option( 'woocommerce-product-generator-per-run', self::DEFAULT_PER_RUN );
			$generated = self::run( $per_run );
			$n_products = self::get_product_count();
			$result = array_merge( array( 'total' => $n_products ), $generated );
			echo json_encode( $result );
			exit;
		}
	}

	public static function generator() {
		if ( !current_user_can( 'manage_woocommerce' ) ) {
			wp_die( __( 'Access denied.', 'woocommerce-product-generator' ) );
		}

		if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'save' ) && wp_verify_nonce( $_POST['product-generator'], 'admin' ) ) {
			$limit        = !empty( $_POST['limit'] ) ? intval( trim( $_POST['limit'] ) ) : self::DEFAULT_LIMIT;
			$per_run      = !empty( $_POST['per_run'] ) ? intval( trim( $_POST['per_run'] ) ) : self::DEFAULT_PER_RUN;
			$use_unsplash = !empty( $_POST['use_unsplash'] );
			$titles       = !empty( $_POST['titles'] ) ? $_POST['titles'] : '';
			$contents     = !empty( $_POST['contents'] ) ? $_POST['contents'] : '';
			$categories   = !empty( $_POST['categories'] ) ? $_POST['categories'] : '';
			$attributes   = !empty( $_POST['attributes'] ) ? $_POST['attributes'] : '';

			if ( $limit < 0 ) {
				$limit = self::DEFAULT_LIMIT;
			}
			delete_option( 'woocommerce-product-generator-limit' );
			add_option( 'woocommerce-product-generator-limit', $limit, null, 'no' );
			// reflect updated limit so script is aware, otherwise it will have the old value
			wp_add_inline_script(
				'product-generator',
				sprintf( 'var ixprogen_updated_limit = %d;', $limit )
			);

			if ( $per_run < 0 ) {
				$per_run = self::DEFAULT_PER_RUN;
			}
			if ( $per_run > self::MAX_PER_RUN ) {
				$per_run = self::MAX_PER_RUN;
			}
			delete_option( 'woocommerce-product-generator-per-run' );
			add_option( 'woocommerce-product-generator-per-run', $per_run, null, 'no' );

			delete_option( 'woocommerce-product-generator-use-unsplash' );
			add_option( 'woocommerce-product-generator-use-unsplash', $use_unsplash, null, 'no' );

			delete_option( 'woocommerce-product-generator-titles' );
			add_option( 'woocommerce-product-generator-title', $titles, null, 'no' );

			delete_option( 'woocommerce-product-generator-contents' );
			add_option( 'woocommerce-product-generator-contents', $contents, null, 'no' );

			$categories = explode( "\n", $categories );
			$categories = array_map( 'trim', $categories );
			$categories = array_unique( $categories );
			$categories = implode( "\n", $categories );
			delete_option( 'woocommerce-product-generator-categories' );
			add_option( 'woocommerce-product-generator-categories', $categories, null, 'no' );

			$save_attributes = '';
			$attribute_defs = explode( "\n", $attributes );
			foreach ( $attribute_defs as $attribute_def ) {
				$attribute_terms = array();
				$attribute = explode( "|", $attribute_def );
				$attribute_name = trim( $attribute[0] );
				if ( strlen( $attribute_name ) > 0 ) {
					if ( isset( $attribute[1] ) ) {
						$maybe_attribute_terms = explode( ',', $attribute[1] );
						foreach ( $maybe_attribute_terms as $maybe_attribute_term ) {
							$maybe_attribute_term = trim( $maybe_attribute_term );
							if ( strlen( $maybe_attribute_term ) > 0 ) {
								if ( !in_array( $maybe_attribute_term, $attribute_terms ) ) {
									$attribute_terms[] = $maybe_attribute_term;
								}
							}
						}
					}
					if ( count( $attribute_terms ) > 0 ) {
						$save_attributes .= sprintf( "%s | %s\n", $attribute_name, implode( ', ', $attribute_terms ) );
					}
				}
			}
			$attributes = $save_attributes;
			delete_option( 'woocommerce-product-generator-attributes' );
			add_option( 'woocommerce-product-generator-attributes', $attributes, null, 'no' );

		} else if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'generate' ) && wp_verify_nonce( $_POST['product-generate'], 'admin' ) ) {
			$max = isset( $_POST['max'] ) ? intval( $_POST['max'] ) : 0;
			if ( $max > 0 ) {

				$time_start = function_exists( 'microtime' ) ? microtime( true ) : time();
				$run_generated = array(
					'simple' => 0,
					'variable' => 0,
					'variation' => 0
				);

				for ( $i = 1; $i <= $max ; $i++ ) {
					$generated = self::create_product();
					$run_generated['simple'] += $generated['simple'];
					$run_generated['variable'] += $generated['variable'];
					$run_generated['variation'] += $generated['variation'];
				}

				$time_stop = function_exists( 'microtime' ) ? microtime( true ) : time();
				$time = $time_stop - $time_start;
				self::log(
					sprintf(
						'WooCommerce Product Generator run created %1$d simple products, %2$d variable products and %3$d variations in %4$f seconds',
						$run_generated['simple'],
						$run_generated['variable'],
						$run_generated['variation'],
						$time
					)
				);

			}
		} else if ( isset( $_POST['action'] ) && ( $_POST['action'] == 'reset' ) && wp_verify_nonce( $_POST['product-generator-reset'], 'admin' ) ) {
			delete_option( 'woocommerce-product-generator-limit' );
			add_option( 'woocommerce-product-generator-limit', self::DEFAULT_LIMIT, null, 'no' );

			delete_option( 'woocommerce-product-generator-per-run' );
			add_option( 'woocommerce-product-generator-per-run', self::DEFAULT_PER_RUN, null, 'no' );

			delete_option( 'woocommerce-product-generator-use-unsplash' );
			add_option( 'woocommerce-product-generator-use-unsplash', self::USE_UNSPLASH, null, 'no' );

			delete_option( 'woocommerce-product-generator-titles' );
			add_option( 'woocommerce-product-generator-title', self::get_default_titles(), null, 'no' );

			delete_option( 'woocommerce-product-generator-contents' );
			add_option( 'woocommerce-product-generator-contents', self::get_default_contents(), null, 'no' );

			delete_option( 'woocommerce-product-generator-categories' );
			add_option( 'woocommerce-product-generator-categories', self::get_default_categories(), null, 'no' );

			delete_option( 'woocommerce-product-generator-attributes' );
			add_option( 'woocommerce-product-generator-attributes', self::get_default_attributes(), null, 'no' );
		}

		$limit    = get_option( 'woocommerce-product-generator-limit', self::DEFAULT_LIMIT );
		$per_run  = get_option( 'woocommerce-product-generator-per-run', self::DEFAULT_PER_RUN );
		$use_unsplash = get_option( 'woocommerce-product-generator-use-unsplash', self::USE_UNSPLASH );
		$titles   = trim( stripslashes( get_option( 'woocommerce-product-generator-titles', self::get_default_titles() ) ) );
		$contents = trim( stripslashes( get_option( 'woocommerce-product-generator-contents', self::get_default_contents() ) ) );
		$categories = trim( stripslashes( get_option( 'woocommerce-product-generator-categories', self::get_default_categories() ) ) );
		$attributes = trim( stripslashes( get_option( 'woocommerce-product-generator-attributes', self::get_default_attributes() ) ) );

		$titles = explode( "\n", $titles );
		sort( $titles );
		$titles = trim( implode( "\n", $titles ) );

		include( 'views/admin-generator.php' );

	}

	/**
	 * Product generation cycle.
	 *
	 * @return array generation stats for the cycle
	 */
	public static function run( $n = self::MAX_PER_RUN ) {

		$time_start = function_exists( 'microtime' ) ? microtime( true ) : time();

		$cycle_generated = array(
			'simple' => 0,
			'variable' => 0,
			'variation' => 0,
			'time' => 0.0
		);

		$limit = intval( get_option( 'woocommerce-product-generator-limit', self::DEFAULT_LIMIT ) );
		$n_products = self::get_product_count();
		if ( $n_products < $limit ) {
			$n = min( $n, $limit - $n_products );
			$n = min( $n, self::MAX_PER_RUN );
			if ( $n > 0 ) {
				for ( $i = 0; $i < $n; $i++ ) {
					$generated = self::create_product();
					$cycle_generated['simple'] += $generated['simple'];
					$cycle_generated['variable'] += $generated['variable'];
					$cycle_generated['variation'] += $generated['variation'];
					$cycle_generated['time'] += $generated['time'];
				}
			}
		}

		$time_stop = function_exists( 'microtime' ) ? microtime( true ) : time();
		$time = $time_stop - $time_start;

		self::log(
			sprintf(
				'WooCommerce Product Generator cycle created %1$d simple products, %2$d variable products and %3$d variations in %4$f seconds',
				$cycle_generated['simple'],
				$cycle_generated['variable'],
				$cycle_generated['variation'],
				$time
			)
		);

		return $cycle_generated;
	}

	/**
	 * Log a message.
	 *
	 * @param string $s
	 *
	 * @since 2.1.0
	 */
	public static function log( $s ) {
		if ( defined( 'WPG_LOG' ) && WPG_LOG ) {
			error_log( $s );
		}
	}

	/**
	 * Returns the total number of published products.
	 *
	 * @return int
	 */
	public static function get_product_count() {
		//$counts = wp_count_posts( 'product' ); // <-- nah ... :|
		global $wpdb;
		return intval( $wpdb->get_var(
			"SELECT count(*) FROM $wpdb->posts WHERE post_type = 'product' and post_status = 'publish'"
		) );
	}

	/**
	 * Set the product author to our user.
	 *
	 * @since 2.0.0
	 *
	 * @param array $data
	 *
	 * @return array
	 */
	public static function woocommerce_new_product_data( $data ) {
		$user_id = self::get_user_id();
		$data['post_author'] = $user_id;
		return $data;
	}

	/**
	 * Takes care of creating a new product.
	 *
	 * @return array generation stats
	 */
	public static function create_product() {

		$time_start = function_exists( 'microtime' ) ? microtime( true ) : time();

		$simple_products_created = 0;
		$variable_products_created = 0;
		$variations_created = 0;

		add_filter( 'woocommerce_new_product_data', array( __CLASS__, 'woocommerce_new_product_data' ) );
		add_filter( 'woocommerce_new_product_variation_data', array( __CLASS__, 'woocommerce_new_product_data' ) );

		$title = self::get_title();
		$i = 0;
		while( ( $i < 99 ) ) {
			if ( get_page_by_title( $title, OBJECT, 'product' ) ) {
				$title .= " " . self::get_title();
			} else {
				break;
			}
			$i++;
		}

		$content = self::get_content();
		$excerpt = self::get_excerpt( 3, $content );

		//
		// Type of product: Simple or Variable
		//
		// Note: random choice of simple or variable product generated, 50% chance of variable product
		//
		$is_variable = ( rand( 1, 100 ) >= 50 );
		if ( $is_variable ) {
			$product = new WC_Product_Variable();
		} else {
			$product = new WC_Product_Simple();
		}

		//
		// Price
		//
		$price = round( floatval( rand( 1, 10000 ) ) / 100.0, 2 );
		$price += -log( rand() / getrandmax() ) * cos( rand() / getrandmax() ) * $price / 10;
		$price = wc_format_decimal( $price, '' );

		//
		// Add categories
		//
		$terms = $term_ids = array();
		$cats = explode( "\n", self::get_categories() );
		$c_n = count( $cats );
		$c_max = rand( 1, 3 );
		for ( $i = 0; $i < $c_max ; $i++ ) {
			$terms[] = $cats[rand( 0, $c_n - 1 )];
		}

		foreach( $terms as $term ){
			if ( false === $term_obj = get_term_by( 'slug', $term, 'product_cat', ARRAY_A ) ) {
				$term_obj = wp_insert_term( $term, 'product_cat' );
			}
			if ( ! is_wp_error( $term_obj ) ) {
				$term_ids[] = $term_obj['term_id'];
			}
		}

		//
		// Add tags
		//
		$tag_ids = array();
		$tags = explode( " ", $title );
		$tags[] = 'progen';
		$potential = explode( " ", $content );
		$n = count( $potential );
		$t_max = rand( 1, 7 );
		for ( $i = 0; $i < $t_max ; $i++ ) {
			$tags[] = preg_replace( "/[^a-zA-Z0-9 ]/", '', $potential[rand( 0, $n-1 )] );
		}

		foreach( $tags as $tag ){
			if ( false === $tag_obj = get_term_by( 'slug', $tag, 'product_tag', ARRAY_A ) ) {
				$tag_obj = wp_insert_term( $tag, 'product_tag' );
			}
			if ( ! is_wp_error( $tag_obj ) ) {
				$tag_ids[] = $tag_obj['term_id'];
			}
		}

		//
		// Add attributes
		//
		$variation_attributes = array();
		$attributes = array();
		$attribute_defs = explode( "\n", self::get_attributes() );

		// choose a subset of available attributes
		$attributes_max = rand( 1, count( $attribute_defs ) );
		shuffle( $attribute_defs );
		$attribute_defs = array_splice( $attribute_defs, 0, $attributes_max );

		foreach ( $attribute_defs as $attribute_def ) {
			$attribute_terms = array();
			$attribute = explode( "|", $attribute_def );
			$attribute_name = trim( $attribute[0] );
			if ( strlen( $attribute_name ) > 0 ) {
				if ( isset( $attribute[1] ) ) {
					$maybe_attribute_terms = explode( ',', $attribute[1] );
					foreach ( $maybe_attribute_terms as $maybe_attribute_term ) {
						$maybe_attribute_term = trim( $maybe_attribute_term );
						if ( strlen( $maybe_attribute_term ) > 0 ) {
							if ( !in_array( $maybe_attribute_term, $attribute_terms ) ) {
								$attribute_terms[] = $maybe_attribute_term;
							}
						}
					}
				}
				if ( count( $attribute_terms ) > 0 ) {
					$n_attributes = rand( 0, count( $attribute_terms ) );
					if ( $n_attributes > 0 ) {
						shuffle( $attribute_terms );
						$attribute_terms = array_slice( $attribute_terms, 0, $n_attributes );
					}
				}

				if ( count( $attribute_terms ) > 0 ) {
					$attribute_taxonomy_id = wc_attribute_taxonomy_id_by_name( $attribute_name );
					if ( $attribute_taxonomy_id === 0 ) {
						$attribute_taxonomy_id = wc_create_attribute( array(
							'name' => $attribute_name
						) );
					}

					if ( is_numeric( $attribute_taxonomy_id ) && $attribute_taxonomy_id > 0 ) {
						$taxonomy_name = wc_attribute_taxonomy_name_by_id( $attribute_taxonomy_id );
						if ( !empty( $taxonomy_name ) ) {
							$use_attribute_terms = $attribute_terms;
							// use only term per attribute one for simple products
							if ( !$is_variable ) {
								shuffle( $use_attribute_terms );
								$use_attribute_terms = array_slice( $use_attribute_terms, 0, 1 );
							}
							$attribute = new WC_Product_Attribute();
							$attribute->set_id( $attribute_taxonomy_id );
							$attribute->set_name( $taxonomy_name );
							$attribute->set_options( $use_attribute_terms );
							$attribute->set_visible( true );
							$attribute->set_variation( true );
							$attributes[] = $attribute;

							$variation_attributes[$taxonomy_name] = $attribute_terms;
						}
					}
				}
			}
		}

		//
		// Product image
		//
		$generate_image = true;
		$use_unsplash = get_option( 'woocommerce-product-generator-use-unsplash', self::USE_UNSPLASH );
		if ( $use_unsplash ) {
			$unsplash_success = false;
			// https://source.unsplash.com/960x960/?what-to-search-for
			$context = stream_context_create( ['http' => ['ignore_errors' => true]] );
			$unsplash_image = file_get_contents( sprintf( 'https://source.unsplash.com/960x960/?%s', esc_url( $title ) ), false, $context );
			if ( isset( $http_response_header[0] ) ) {
				if (
					strpos( $http_response_header[0], '200' ) !== false || // OK
					strpos( $http_response_header[0], '302' ) !== false // Found
				) {
					$unsplash_success = true;
				}
			}
			if ( $unsplash_success ) {
				$image_name = self::get_image_name();
				$r = wp_upload_bits( $image_name, null, $unsplash_image );
				if ( !empty( $r ) && is_array( $r ) && !empty( $r['file'] ) ) {
					$filetype = wp_check_filetype( $r['file'] );
					$attachment_id = wp_insert_attachment(
						array(
							'post_author' => self::get_user_id(),
							'post_title' => $title,
							'post_mime_type' => $filetype['type'],
							'post_status' => 'publish'
						),
						$r['file'],
						$product->get_id()
					);
					if ( !empty( $attachment_id ) && !( $attachment_id instanceof WP_Error ) ) {
						$generate_image = false;
						include_once ABSPATH . 'wp-admin/includes/image.php';
						if ( function_exists( 'wp_generate_attachment_metadata' ) ) {
							$meta = wp_generate_attachment_metadata( $attachment_id, $r['file'] );
							wp_update_attachment_metadata( $attachment_id, $meta );
						}
					}
				}
			}
		}
		if ( $generate_image ) {
			$image = self::get_image();
			$image_name = self::get_image_name();
			$attachment_id = '';
			$r = wp_upload_bits( $image_name, null, $image );
			if ( !empty( $r ) && is_array( $r ) && !empty( $r['file'] ) ) {
				$filetype = wp_check_filetype( $r['file'] );
				$attachment_id = wp_insert_attachment(
					array(
						'post_author' => self::get_user_id(),
						'post_title' => $title,
						'post_mime_type' => $filetype['type'],
						'post_status' => 'publish',
					),
					$r['file'],
					$product->get_id()
				);
				if ( !empty( $attachment_id ) && !( $attachment_id instanceof WP_Error ) ) {
					include_once ABSPATH . 'wp-admin/includes/image.php';
					if ( function_exists( 'wp_generate_attachment_metadata' ) ) {
						$meta = wp_generate_attachment_metadata( $attachment_id, $r['file'] );
						wp_update_attachment_metadata( $attachment_id, $meta );
					}
				}
			}
		}

		//
		// SKU
		//

		// This class will do the SKUs if present
		$has_sku_generator = class_exists( 'WC_SKU_Generator' ) && method_exists( 'WC_SKU_Generator', 'maybe_save_sku' );

		// Generate our SKU
		if ( !$has_sku_generator ) {
			$sku = '';
			$sku_parts = explode( ' ', $title );
			foreach ( $sku_parts as $sku_part ) {
				$sku_part = substr( $sku_part, 0, min( strlen( $sku_part ), 2 ) );
				$sku_part = strtoupper( $sku_part );
				$sku .= $sku_part;
			}

			$max_sku_i = 10000;
			$sku_i = 0;
			do {
				$sku_i++;
				$maybe_sku = $sku;
				if ( $sku_i > 1 ) {
					$maybe_sku .= $sku_i;
				}
				$sku_taken = false;
				$id_by_sku = wc_get_product_id_by_sku( $maybe_sku );
				if ( $id_by_sku !== null && is_numeric( $id_by_sku ) ) {
					if ( intval( $id_by_sku ) > 0 ) {
						$sku_taken = true;
					}
				}
			} while (
				$sku_i <= $max_sku_i &&
				$sku_taken
			);
			// last resort ...
			if ( $sku_i >= $max_sku_i ) {
				$sku .= rand( 0, PHP_INT_MAX );
			} else {
				$sku = $maybe_sku;
			}
		}

		//
		// Featured?
		//
		// Note: don't include product_variation as post_type here as we only count simple and variable base products
		//
		$published_product_ids = wc_get_products( array(
			'post_type' => 'product',
			'status' => 'publish',
			'return' => 'ids',
			'limit' => -1
		) );
		$products_count = count( $published_product_ids );
		// 1% featured
		$is_featured = ( rand( 0, $products_count) >= ceil( 0.99 * $products_count ) );

		//
		// On sale?
		//
		// 10% are on sale
		//
		$sale_price = null;
		$is_on_sale = ( rand( 0, $products_count) >= ceil( 0.090 * $products_count ) );
		if ( $is_on_sale ) {
			$sale_price = round( rand( 75, 90 ) * $price / 100, 2 );
			$sale_price = wc_format_decimal( $sale_price, '' );
		}

		//
		// Stock?
		//
		// 30% are out of stock or on backorder
		$stock_status = 'instock';
		if ( rand( 1, 100 ) >= 70 ) {
			if ( rand( 1, 100 ) >= 50 ) {
				$stock_status = 'outofstock';
			} else {
				$stock_status = 'onbackorder';
			}
		}
		$product->set_stock_status( $stock_status );
		// 50% have explicit stock management set for the product
		$stock = null;
		$manage_stock = ( rand( 1, 100 ) >= 50 );
		if ( $manage_stock ) {
			$stock = abs( intval( -log( rand() / getrandmax() ) * cos( rand() / getrandmax() ) * 0.1 * cos( exp( rand() / getrandmax() ) ) * 10000 ) );
		}

		$props = array(
			'name'               => $title,
			'price'              => $price,
			'regular_price'      => $price,
			'description'        => $content,
			'visibility'	     => 'visible',
			'short_description'  => $excerpt,
			'category_ids'       => $term_ids,
			'tag_ids'            => $tag_ids,
			'status'             => 'publish',
			'catalog_visibility' => 'visible',
			'image_id'           => $attachment_id,
			'featured'           => $is_featured,
			'stock_status'       => $stock_status,
			'backorders'         => 'yes'
		);

		$product->set_props( $props );
		if ( count( $attributes ) > 0 ) {
			$product->set_attributes( $attributes );
		}

		if ( !$has_sku_generator ) {
			$product->set_sku( $sku );
		}

		if ( $sale_price !== null ) {
			$product->set_sale_price( $sale_price );
		}

		if ( $manage_stock && $stock !== null ) {
			if ( !$is_variable ) {
				$product->set_manage_stock( true );
				$product->set_stock_quantity( $stock );
			} else {
				$product->set_manage_stock( false );
			}
		}

		$product->save();

		if ( $is_variable ) {
			$variable_products_created++;
		} else {
			$simple_products_created++;
		}

		if ( $has_sku_generator ) {
			$sku_generator = new WC_SKU_Generator();
			$sku_generator->maybe_save_sku( $product->get_id() );
			unset( $sku_generator );
		}

		// variations
		if ( $is_variable ) {
			$max = 1;
			foreach ( $variation_attributes as $taxonomy_name => $terms ) {
				$max *= count( $terms );
			}
			$max = rand( 1, $max );
			$combos = array();
			for ( $i = 0; $i < $max; $i++ ) {
				$pick = array();
				foreach ( $variation_attributes as $taxonomy_name => $terms ) {
					$n = rand( 0, count( $terms ) - 1 );
					$pick[$taxonomy_name] = sanitize_title( $terms[$n] ); // MUST use the slug, thus applying sanitize_title()
				}
				$hash = md5( json_encode( $pick ) );
				if ( !key_exists( $hash, $combos ) ) {
					$combos[$hash] = $pick;
				}
			}
			if ( count( $combos ) > 0 ) {
				$i = 1;
				foreach ( $combos as $combo ) {
					$variation = new WC_Product_Variation();
					$variation->set_parent_id( $product->get_id() );
					$variation->set_attributes( $combo );
					$variation_price = round( $price * ( 1 + rand( -25, 25 ) / 100 ), 2 );
					$variation_price = wc_format_decimal( $variation_price, '' );
					$variation->set_price( $variation_price );
					$variation->set_regular_price( $variation_price );
					if ( !$has_sku_generator ) {
						$variation->set_sku( $sku . '-' . $i );
					}
					// if the product has a chance of being on sale, allow for 50% of variations to be on sale
					if ( $is_on_sale ) {
						$is_on_sale = ( rand( 0, $products_count) >= ceil( 0.50 * $products_count ) );
						if ( $is_on_sale ) {
							$variation_sale_price = round( rand( 75, 90 ) * $variation_price / 100, 2 );
							$variation_sale_price = wc_format_decimal( $variation_sale_price, '' );
							$variation->set_sale_price( $variation_sale_price );
						}
					}
					// stock of this variation
					// 30% are out of stock or on backorder
					$stock_status = 'instock';
					if ( rand( 1, 100 ) >= 70 ) {
						if ( rand( 1, 100 ) >= 50 ) {
							$stock_status = 'outofstock';
						} else {
							$stock_status = 'onbackorder';
						}
					}
					$variation->set_stock_status( $stock_status );
					if ( $manage_stock ) { // from the parent
						$stock = abs( intval( -log( rand() / getrandmax() ) * cos( rand() / getrandmax() ) * 0.1 * cos( exp( rand() / getrandmax() ) ) * 10000 ) );
						$variation->set_manage_stock( true );
						$variation->set_stock_quantity( $stock );
					}

					$variation->save();
					$i++;
					$variations_created++;

					if ( $has_sku_generator ) {
						$sku_generator = new WC_SKU_Generator();
						$sku_generator->maybe_save_sku( $variation->get_id() );
						unset( $sku_generator );
					}
				}
			}
		}

		remove_filter( 'woocommerce_new_product_data', array( __CLASS__, 'woocommerce_new_product_data' ) );
		remove_filter( 'woocommerce_new_product_variation_data', array( __CLASS__, 'woocommerce_new_product_data' ) );

		$time_stop = function_exists( 'microtime' ) ? microtime( true ) : time();
		$time = $time_stop - $time_start;
		if ( $is_variable ) {
			self::log(
				sprintf(
					'WooCommerce Product Generator created 1 variable product with %1$d variations in %2$f seconds',
					$variations_created,
					$time
				)
			);
		} else {
			self::log(
				sprintf(
					'WooCommerce Product Generator created 1 simple product in %1$f seconds',
					$time
				)
			);
		}

		return array(
			'simple'    => $simple_products_created,
			'variable'  => $variable_products_created,
			'variation' => $variations_created,
			'time'      => $time
		);
	}

	/**
	 * Returns the user ID of the product-generator user which is used as the
	 * author of products generated. The user is created here if it doesn't
	 * exist yet, with role Shop Manager.
	 *
	 * @return int product-generator user ID
	 */
	public static function get_user_id() {
		$user_id = get_current_user_id();
		$user = get_user_by( 'login', 'product-generator' );
		if ( $user instanceof WP_User ) {
			$user_id = $user->ID;
		} else {

			$user_pass = wp_generate_password( 12 );
			$maybe_user_id = wp_insert_user( array(
				'user_login' => 'product-generator',
				'role'       => 'shop_manager',
				'user_pass'  => $user_pass
			) );
			if ( !( $maybe_user_id instanceof WP_Error ) ) {
				$user_id = $maybe_user_id;

				// notify admin
				$user = get_userdata( $user_id );
				$blogname = wp_specialchars_decode( get_option( 'blogname' ), ENT_QUOTES );

				$message  = sprintf( __( 'Product generator user created on %s:', 'woocommerce-product-generator' ), $blogname ) . "\r\n\r\n";
				$message .= sprintf( __( 'Username: %s', 'woocommerce-product-generator' ), $user->user_login ) . "\r\n\r\n";
				$message .= sprintf( __( 'Password: %s', 'woocommerce-product-generator' ), $user_pass ) . "\r\n\r\n";
				$message .= __( 'The user has the role of a Shop Manager.', 'woocommerce-product-generator' ) . "\r\n";

				@wp_mail( get_option( 'admin_email' ), sprintf( __( '[%s] Product Generator User', 'woocommerce-product-generator' ), $blogname ), $message);
			}
		}
		return $user_id;
	}

	/**
	 * Produce a title.
	 *
	 * @param int $n_words
	 * @return string
	 */
	public static function get_title( $n_words = 3 ) {
		$titles = trim( stripslashes( get_option( 'woocommerce-product-generator-titles', self::get_default_titles() ) ) );
		$titles = explode( "\n", $titles );
		$title = array();
		$n = count( $titles );
		$n_words = rand( 1, $n_words );
		for ( $i = 1; $i <= $n_words ; $i++ ) {
			$title[] = $titles[rand( 0, $n - 1 )];
		}
		$title = implode( ' ', $title );
		return $title;
	}

	/**
	 * Produce the excerpt.
	 *
	 * @param int $n_lines
	 * @return string
	 */
	public static function get_excerpt( $n_lines = 3, $contents = null ) {
		if ( $contents === null ) {
			$contents = trim( stripslashes( get_option( 'woocommerce-product-generator-contents', self::get_default_contents() ) ) );
		} else {
			$contents = str_ireplace( '</p>', "\n", $contents );
			$contents = str_ireplace( '<p>', '', $contents );
		}
		$contents = explode( "\n", $contents );
		$content = array();
		$n = count( $contents );
		$n_lines = rand( 1, $n_lines );
		for ( $i = 1; $i <= $n_lines ; $i++ ) {
			$maybe_content = $contents[rand( 0, $n - 1 )];
			if ( !in_array( $maybe_content, $content ) ) {
				$content[] = $maybe_content;
			}
		}
		$content = "<p>" . implode( "</p><p>", $content ) . "</p>";
		return $content;
	}

	/**
	 * Produce content.
	 *
	 * @param int $n_lines
	 * @return string
	 */
	public static function get_content( $n_lines = 10 ) {
		$contents = trim( stripslashes( get_option( 'woocommerce-product-generator-contents', self::get_default_contents() ) ) );
		$contents = explode( "\n", $contents );
		$content = array();
		$n = count( $contents );
		$n_lines = rand( 1, $n_lines );
		for ( $i = 1; $i <= $n_lines ; $i++ ) {
			$content[] = $contents[rand( 0, $n - 1 )];
		}
		$content = "<p>" . implode( "</p><p>", $content ) . "</p>";
		return $content;
	}

	/**
	 * Get the categories.
	 *
	 * @return string
	 */
	public static function get_categories() {
		$categories = trim( stripslashes( get_option( 'woocommerce-product-generator-categories', self::get_default_categories() ) ) );
		return $categories;
	}

	/**
	 * Get the attribute definitions.
	 *
	 * @return string
	 */
	public static function get_attributes() {
		$attributes = trim( stripslashes( get_option( 'woocommerce-product-generator-attributes', self::get_default_attributes() ) ) );
		return $attributes;
	}

	/**
	 * Produce an image.
	 *
	 * @return string image data
	 */
	public static function get_image() {
		$output = '';
		if ( function_exists( 'imagepng' ) ) {
			$width = self::IMAGE_WIDTH;
			$height = self::IMAGE_HEIGHT;

			$image = imagecreatetruecolor( $width, $height );
			for( $i = 0; $i <= 11; $i++ ) {
				$x = rand( 0, $width );
				$y = rand( 0, $height );
				$w = rand( 1, $width );
				$h = rand( 1, $height );
				$red = rand( 0, 255 );
				$green = rand( 0, 255 );
				$blue  = rand( 0, 255 );
				$color = imagecolorallocate( $image, $red, $green, $blue );
				imagefilledrectangle(
					$image,
					intval( $x - $w / 2 ),
					intval( $y - $h / 2 ),
					intval( $x + $w / 2 ),
					intval( $y + $h / 2 ),
					intval( $color )
				);
			}

			ob_start();
			imagepng( $image );
			$output = ob_get_clean();
			imagedestroy( $image );
		} else {
			$image = file_get_contents( WOOPROGEN_PLUGIN_URL . '/images/placeholder.png' );
			ob_start();
			echo $image;
			$output = ob_get_clean();
		}
		return $output;

	}

	/**
	 * Produce a name for an image.
	 * @return string
	 */
	public static function get_image_name() {
		$t = time();
		$r = rand();
		return "product-$t-$r.png";
	}

	/**
	 * Returns true if WooCommerce is active.
	 *
	 * @return boolean true if WooCommerce is active
	 */
	private static function woocommerce_is_active() {
		$active_plugins = get_option( 'active_plugins', array() );
		if ( is_multisite() ) {
			$active_sitewide_plugins = get_site_option( 'active_sitewide_plugins', array() );
			$active_sitewide_plugins = array_keys( $active_sitewide_plugins );
			$active_plugins = array_merge( $active_plugins, $active_sitewide_plugins );
		}
		return in_array( 'woocommerce/woocommerce.php', $active_plugins );
	}

	/**
	 * Get default titles from file.
	 *
	 * @return string
	 *
	 * @since  1.2.0
	 */
	private static function get_default_titles() {
		if( ! self::$default_titles ) {
			$content = file_get_contents( plugin_dir_path( __FILE__ ) . 'dummy-content/dummy-titles.txt' );
			if( $content !== false ) {
				self::$default_titles = $content;
			}
		}
		return self::$default_titles;
	}

	/**
	 * Get default content from file.
	 *
	 * @return string
	 *
	 * @since  1.2.0
	 */
	private static function get_default_contents() {
		if( ! self::$default_contents ) {
			$content = file_get_contents( plugin_dir_path( __FILE__ ) . 'dummy-content/dummy-contents.txt' );
			if( $content !== false ) {
				self::$default_contents = $content;
			}
		}
		return self::$default_contents;
	}

	/**
	 * Get default categories from file.
	 *
	 * @return string
	 *
	 * @since  1.2.0
	 */
	private static function get_default_categories() {
		if( ! self::$default_categories ) {
			$content = file_get_contents( plugin_dir_path( __FILE__ ) . 'dummy-content/dummy-categories.txt' );
			if( $content !== false ) {
				self::$default_categories = $content;
			}
		}
		return self::$default_categories;
	}

	/**
	 * Get default attributes from file.
	 *
	 * @return string
	 *
	 * @since 2.0.0
	 */
	private static function get_default_attributes() {
		if ( ! self::$default_attributes ) {
			$content = file_get_contents( plugin_dir_path( __FILE__ ) . 'dummy-content/dummy-attributes.txt' );
			if( $content !== false ) {
				self::$default_attributes = $content;
			}
		}
		return self::$default_attributes;
	}

}
add_action( 'woocommerce_loaded', array( 'WooCommerce_Product_Generator', 'init' ) );
