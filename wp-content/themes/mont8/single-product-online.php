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

			global $product;
			$store_info = dokan_get_store_info( $product->post->post_author );
		?>
	</div>

	<section class="related-artworks artists-artwork">

		<div class="row same-artists" style="clear:both;">
			<h3 class="text-center "><?php _e( 'MORE FROM ', 'woocommerce' ); ?> <a
					href="<?= dokan_get_store_url( get_the_author_meta( 'ID' ) ) ?>"><?= $store_info['store_name'] ?></a>
			</h3>
			<?= do_shortcode( '[recent_products per_page="5" columns="5" orderby="rand" author="' . get_the_author_meta( 'ID' ) . '" order="rand"]' ) ?>
		</div>

		<div class="row recommended-images" style="clear:both;">
			<h3 class="text-center"><?php _e( 'RECOMMENDED FOR YOU', 'woocommerce' ); ?></h3>
			<?= do_shortcode( '[recent_products per_page="5" columns="5" orderby="rand" order="rand"]' ) ?>
		</div>
	</section>
	<!-- #content .site-content -->
</div><!-- #primary .content-area -->


<?php disqus_embed( 'mont8' ); ?>

