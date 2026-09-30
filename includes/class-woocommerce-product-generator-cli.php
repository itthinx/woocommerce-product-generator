<?php
/**
 * class-wc-product-generator-cli.php
 *
 * WP-CLI Command for WooCommerce Product Generator
 *
 * @author gtsiokos
 * @package woocommerce-product-generator
 * @since 4.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( defined( 'WP_CLI' ) && WP_CLI ) {

	class WooCommerce_Product_Generator_CLI {

		/**
		 * Generates mock products via WooCommerce Product Generator.
		 *
		 * ## OPTIONS
		 *
		 * [--count=<number>]
		 * : The number of products to generate.
		 * ---
		 * default: 1
		 * ---
		 *
		 * ## EXAMPLES
		 *
		 *     wp wc-generate-products --count=50
		 *
		 * @param array $args       Positional arguments.
		 * @param array $assoc_args Associative arguments (options).
		 */
		public function __invoke( $args, $assoc_args ) {
			$count = intval( $assoc_args['count'] ) ? intval( $assoc_args['count'] ) : 1;

			WP_CLI::log( sprintf( 'Starting generation of %d products...', $count ) );

			if ( class_exists( 'WooCommerce_Product_Generator' ) ) {
				try {
					for ( $i = 0; $i < $count; $i++ ) {
						WooCommerce_Product_Generator::create_product();
					}
					WP_CLI::success( sprintf( 'Successfully generated %d products!', $count ) );
				} catch ( Exception $e ) {
					WP_CLI::error( 'Generation failed: ' . $e->getMessage() );
				}
			} else {
				WP_CLI::error( 'Product Generator for WooCommerce core class not found.' );
			}
		}
	}
}
