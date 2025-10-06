=== Product Generator for WooCommerce ===
Contributors: itthinx, proaktion, helgatheviking, jamesgol, akshayar
Donate link: https://www.itthinx.com/shop/
Tags: benchmark, generator, performance, product, woocommerce
Requires at least: 6.5
Requires PHP: 7.4.0
Tested up to: 6.8
Stable tag: 3.1.0
License: GPLv3

A sample product generator for WooCommerce.

== Description ==

This is a sample product generator for WooCommerce, for use on development and testing sites.

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

The plugin provides an administrative section <strong>WooCommerce > Product Generator</strong> where several aspects can be adjusted.

During the <em>Continuous AJAX Run</em>, the cumulative product generation stats and performance are shown.

The product generation stats and performance are also logged to the site's debug.log. To disable, add this to your site's wp-config.php: <code>define( 'WPG_LOG', false );</code>

With the stats provided, this plugin also provides an easy way to benchmark a site: providing an insight into the site's performance measured by products generated per second. If you want to measure the performance of your site while generating products, make sure to <strong>disable</strong> the option <em>Get images from Unsplash</em>, as the impact of getting images via the network will be much higher than the product generation itself.

Fork the [Repository](https://github.com/itthinx/woocommerce-product-generator) to customize the products generated as desired.

== Installation ==

= Dashboard =

Log in as an administrator and go to <strong>Plugins > Add New</strong>.

Type <em>Product Generator</em> in the search field, locate the <em>Product Generator for WooCommerce<em> plugin by <em>itthinx</em> and install it by clicking <em>Install Now</em>.

Now <em>activate</em> the plugin to be able to generate sample products.

= FTP =

You can install the plugin via FTP, see [Manual Plugin Installation](https://codex.wordpress.org/Managing_Plugins#Manual_Plugin_Installation).

== Screenshots ==

1. WooCommerce menu integration.
2. Generator settings.
3. Generator actions, single and continuous product generation runs.
4. Continuous generator running.
5. Some sample products generated.

== Changelog ==

[Changelog.txt](https://github.com/itthinx/woocommerce-product-generator/blob/master/changelog.txt)

== Upgrade Notice ==

Tested with the latest versions of WordPress and WooCommerce at the time of the release.
