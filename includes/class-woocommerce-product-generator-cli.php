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

/**
 * @since 2.0.0
 */
class WooCommerce_Product_Generator_CLI {

	/**
	 * Register command.
	 */
	public static function boot() {
		WP_CLI::add_command( 'product-generator', 'WooCommerce_Product_Generator_CLI' );
	}

	/**
	 * Generates mock products via WooCommerce Product Generator.
	 *
	 * Command line arguments:
	 *
	 * --count=<number> : Optional. The number of products to generate. Default: 1.
	 *
	 * Examples:
	 *
	 * Generate one product:
	 *
	 *  $ wp product-generator
	 *
	 * Generate ten products:
	 *
	 *  $ wp product-generator --count=10
	 *
	 * @param array $args       Positional arguments.
	 * @param array $assoc_args Associative arguments (options).
	 */
	public function __invoke( $args, $assoc_args ) {
		$count = intval( $assoc_args['count'] ?? 1 );

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

WooCommerce_Product_Generator_CLI::boot();
