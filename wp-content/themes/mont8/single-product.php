<?php

	/**
	 * The Template for displaying all single products.
	 *
	 * @package Dokan
	 * @subpackage WooCommerce/Templates
	 * @version 1.6.4
	 */

	// Enque the required dependencies on this page - iboostme/hooks.php
	load_product_page_assets();
	

	get_header();

?>

<?php //get_sidebar( 'product-single' ); ?>

	<div id="primary" class="content-area col-md-12">
		<div id="content" class="site-content" role="main">

			<?php
				/**
				 * woocommerce_before_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
				 * @hooked woocommerce_breadcrumb - 20
				 */
				do_action( 'woocommerce_before_main_content' );
			?>

			<?php while ( have_posts() ) : the_post(); ?>

				<?php wc_get_template_part( 'content', 'single-product' ); ?>

			<?php endwhile; // end of the loop. ?>

			<?php
				/**
				 * woocommerce_after_main_content hook
				 *
				 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
				 */
				do_action( 'woocommerce_after_main_content' );
			?>
		</div>

		<section class="related-artworks artists-artwork">

			<div class="row same-artists" style="clear:both;">
				<h2 class="text-center nice-title"><?php _e( 'SAME ARTISTS', 'woocommerce' ); ?></h2>
				<?=do_shortcode('[recent_products per_page="5" columns="5" orderby="rand" author="1" order="rand"]')?>
			</div>

			<div class="row recommended-images" style="clear:both;" >
				<h2 class="text-center nice-title"><?php _e( 'RECOMMENDED FOR YOU', 'woocommerce' ); ?></h2>
				<?=do_shortcode('[recent_products per_page="5" columns="5" orderby="rand" order="rand"]')?>
			</div>
		</section>
		<!-- #content .site-content -->
	</div><!-- #primary .content-area -->



	<?php disqus_embed('mont8'); ?>

<?php get_footer(); ?>