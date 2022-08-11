<?php
/**
 * Admin View
 *
 * @author itthinx
 * @package woocommerce-product-generator
 * @since 1.2.0
 *
 */
?>

<h1><?php _e( 'Product Generator', 'woocommerce-product-generator' ); ?></h1>

<div class="product-generator-admin" style="margin-right:1em;">

	<div>
		<p><?php esc_html_e( 'This produces demo products for testing purposes.', 'woocommerce-product-generator' ); ?></p>

		<p><?php echo wp_kses_post( __( 'It is <strong>NOT</strong> recommended to use this on a production site.', 'woocommerce-product-generator' ) ) ; ?></p>

		<p><?php echo wp_kses_post( __( 'The plugin will <strong>NOT</strong> clean up the data it has created.', 'woocommerce-product-generator' ) ); ?></p>

		<p><?php echo wp_kses_post( __( 'The plugin will create a <em>product-generator</em> user in the role of a <em>Shop Manager</em>.', 'woocommerce-product-generator' ) ); ?></p>

		<p><?php echo wp_kses_post( __( "Product generation stats and performance are logged to your site's debug.log, unless the <code>WPG_LOG</code> constant is used to disable that by setting it to false in your site's <code>wp-config.php</code>.", 'woocommerce-product-generator' ) ); ?></p>
	</div>

	<div class="settings">
		<form name="settings" method="post" action="">
			<p><?php esc_html_e( 'The continuous generator runs at most once per second, creating up to the indicated number of products per run.', 'woocommerce-product-generator' ); ?></p>
			<p><?php esc_html_e( 'The continuous generator will try to create new products until stopped, or the total number of products reaches the indicated limit.', 'woocommerce-product-generator' ); ?></p>

			<p>
				<label><?php esc_html_e( 'Limit', 'woocommerce-product-generator' );?>
				<input type="text" name="limit" value="<?php echo esc_attr( $limit );?>" />
				</label>
			</p>

			<p>
				<label><?php esc_html_e( 'Per Run', 'woocommerce-product-generator' );?>
				<input type="text" name="per_run" value="<?php echo esc_attr( $per_run );?>" />
				<?php printf( esc_html__( 'Maximum %d', 'woocommerce-product-generator' ), self::MAX_PER_RUN ); ?>
				</label>
			</p>

			<p>
				<label><?php esc_html_e( 'Images', 'woocommerce-product-generator' );?>
				&nbsp;
				<input type="checkbox" name="use_unsplash" value="1" <?php echo $use_unsplash ? 'checked' : ''; ?> />
				<?php printf( __( 'Get images from <a href="https://unsplash.com/">Unsplash</a>', 'woocommerce-product-generator' ), self::USE_UNSPLASH ); ?>
				</label>
				<br/>
				<?php esc_html_e( 'Product images are generated if this is disabled or can not be obtained.', 'woocommerce-product-generator' ); ?>
				<br/>
				<?php echo wp_kses_post( __( 'If you want to measure the performance of your site while generating products using the logged stats and those provided under <em>Continuous AJAX Run</em>, make sure to <strong>disable</strong> this option, as the impact of getting images via the network will be much higher than the product generation itself.', 'woocommerce-product-generator' ) ); ?>
			</p>

			<p>
				<label><?php esc_html_e( 'Titles', 'woocommerce-product-generator' ); ?>
				<br/>
				<textarea name="titles" style="height:10em;width:90%;"><?php echo htmlentities( $titles ); ?></textarea>
				</label>
			</p>

			<p>
				<label>
				<?php esc_html_e( 'Contents', 'woocommerce-product-generator' ); ?>
				<br/>
				<textarea name="contents" style="height:20em;width:90%;"><?php echo htmlentities( $contents ); ?></textarea>
				</label>
			</p>

			<p>
				<label>
				<?php esc_html_e( 'Categories', 'woocommerce-product-generator' ); ?>
				<br/>
				<textarea name="categories" style="height:10em;width:90%;"><?php echo htmlentities( $categories ); ?></textarea>
				<br/>
				<?php echo wp_kses_post( __( 'Provide one category per line', 'woocommerce-product-generator' ) ); ?>
				</label>
			</p>

			<p>
				<label>
				<?php esc_html_e( 'Attributes', 'woocommerce-product-generator' ); ?>
				<br/>
				<textarea name="attributes" style="height:10em;width:90%;"><?php echo htmlentities( $attributes ); ?></textarea>
				<br/>
				<?php echo wp_kses_post( __( 'Each attribute line must use the format: <code>Name | term1, term2, ...</code>', 'woocommerce-product-generator' ) ); ?>
				</label>
			</p>

		<?php wp_nonce_field( 'admin', 'product-generator', true, true ); ?>

		<div class="buttons">
			<input class="button button-primary" type="submit" name="submit" value="<?php esc_html_e( 'Save', 'woocommerce-product-generator' ); ?>" />
			<input type="hidden" name="action" value="save" />
		</div>

	</form>

	<h2><?php esc_html_e( 'Reset', 'woocommerce-product-generator' ); ?></h2>

	<div class="reset">
		<form name="reset" method="post" action="">
			<p>
			<?php esc_html_e( 'Reset to defaults', 'woocommerce-product-generator' ); ?>
			</p>

			<?php wp_nonce_field( 'admin', 'product-generator-reset', true, true ); ?>

			<div class="buttons">
			<button class="button button-primary" type="submit" name="submit"><?php esc_html_e( 'Reset', 'woocommerce-product-generator' ); ?></button>
			<input type="hidden" name="action" value="reset" />
			</div>

		</form>
	</div>

	<h2><?php _e( 'Single Run', 'woocommerce-product-generator' ); ?></h2>

	<div class="generate">
		<form name="generate" method="post" action="">

			<p>
			<label>
			<?php esc_html_e( 'Generate up to &hellip;', 'woocommerce-product-generator' ); ?>
			<input type="text" name="max" value="1" />
			</label>
			</p>

			<?php wp_nonce_field( 'admin', 'product-generate', true, true ); ?>

			<div class="buttons">
				<button class="button button-primary" type="submit" name="submit" ><?php esc_html_e( 'Run', 'woocommerce-product-generator' ); ?></button>
				<input type="hidden" name="action" value="generate" />
			</div>

		</form>
	</div>

	<h2><?php esc_html_e( 'Continuous AJAX Run', 'woocommerce-product-generator' ); ?></h2>

	<div class="buttons">
		<button class="button" type="button" id="product-generator-run" name="product-generator-run"><?php esc_html_e( 'Run', 'woocommerce-product-generator' );?></button>
		<button class="button" type="button" id="product-generator-stop" name="product-generator-stop"><?php esc_html_e( 'Stop', 'woocommerce-product-generator' ); ?></button>
	</div>

	<div id="product-generator-status"></div>
	<div id="product-generator-update"></div>
	<div id="product-generator-blinker"></div>

</div>