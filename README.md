woocommerce-product-generator
=============================

# A sample product generator for WooCommerce

This WordPress plugin is a sample product generator for WooCommerce, for use on development and testing sites.

Its purpose is to provide an automated way of creating even very large sets of products, useful in providing a test environment for performance benchmarks and use case testing.

The plugin generates products taking into account the following characteristics:

- Product Categories
- Product Tags
- Product Attributes
- SKUs
- Simple and Variable products with variations based on given attributes
- Stock management and stock numbers (some products will have these set, others won't)
- Featured products (a minor subset will be marked as featured)
- Product images can be obtained from [Unsplash](https://unsplash.com/) or abstract images generated

The plugin provides an administrative section **WooCommerce > Product Generator** where its settings can be adjusted.

During the *Continuous AJAX Run*, the cumulative product generation stats and performance are shown.

The product generation stats and performance are also logged to the site's debug.log. To disable, add the line `define( 'WPG_LOG', false );` to your site's `wp-config.php`.

With the stats provided, this plugin also provides an easy way to benchmark a site: providing an insight into the site's performance measured by products generated per second. If you want to measure the performance of your site while generating products, make sure to **disable** the option *Get images from Unsplash*, as the impact of getting images via the network will be much higher than the product generation itself.

Fork the [Repository](https://github.com/itthinx/woocommerce-product-generator) to customize the products generated as desired.
