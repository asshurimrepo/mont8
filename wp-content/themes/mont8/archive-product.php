<?php
/**
 * The template for displaying Archive pages.
 *
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package Dokan
 * @subpackage WooCommerce/Templates
 * @version 2.0.0
 */
 global $wp_query;
// 	var_dump($wp_query->query_vars);


get_header(); ?>


<div id="primary" class="content-area col-md-12">

<div class="archive-title clearfix">
		<?php if ( apply_filters( 'woocommerce_show_page_title', true ) ) : ?>

			<h1 class="entry-title"><?php woocommerce_page_title(); ?></h1>

		<?php endif; ?>

			<?php
				/**
				 * woocommerce_before_shop_loop hook
				 *
				 * @hooked woocommerce_result_count - 20
				 * @hooked woocommerce_catalog_ordering - 30
				 */
				//do_action( 'woocommerce_before_shop_loop' );
			?>

		</div>
        
        </div>

<?php get_sidebar( 'shop' ); ?>
<div id="primary" class="content-area col-md-9">
    <div id="content" class="site-content" role="main">
    


	<?php
		/**
		 * woocommerce_before_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper - 10 (outputs opening divs for the content)
		 * @hooked woocommerce_breadcrumb - 20
		 */
		do_action('woocommerce_before_main_content');
	?>

		<?php do_action( 'woocommerce_archive_description' ); ?>

		<?php if ( have_posts() ) : ?>


			<?php //woocommerce_product_loop_start(); ?>

				<?php woocommerce_product_subcategories(); ?>


			<div id="gallery-freewall"">



			<?php $i = 0; while ( have_posts() ) : the_post(); ?>

					<?php wc_get_template_part( 'content-archive', 'product' ); ?>

					<?php if($i%3==2):?>
						<div class="col-md-12">&nbsp;</div>
					<?php endif; ?>

			<?php $i++; endwhile; // end of the loop. ?>


			</div>

			<?php //woocommerce_product_loop_end(); ?>

			<?php
				/**
				 * woocommerce_after_shop_loop hook
				 *
				 * @hooked woocommerce_pagination - 10
				 */
				do_action( 'woocommerce_after_shop_loop' );
			?>

		<?php elseif ( ! woocommerce_product_subcategories( array( 'before' => woocommerce_product_loop_start( false ), 'after' => woocommerce_product_loop_end( false ) ) ) ) : ?>

			<?php wc_get_template( 'loop/no-products-found.php' ); ?>

		<?php endif; ?>

	<?php
		/**
		 * woocommerce_after_main_content hook
		 *
		 * @hooked woocommerce_output_content_wrapper_end - 10 (outputs closing divs for the content)
		 */
		do_action('woocommerce_after_main_content');
	?>

	</div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<script>
	(function($){


	    $(".tagcloud a").remove();

	    $("#mega_main_menu_ul li:nth-child(1) .mega_dropdown a").each(function(){

			var item = $(this).clone();

			item.appendTo(".tagcloud");

	    });

		$(".dropdown_product_cat *").remove();
		$(".dropdown_product_cat").append( $('<option>').text('Select Category') );
	    $("#mega_main_menu_ul li:nth-child(2) .mega_dropdown a").each(function(){

			var link = $(this).prop('href');
			var is_active = link == document.URL;
			var slug = link.split("/");
			var text = $(this).text();

			$(".dropdown_product_cat").append( $('<option>').attr('value', slug[4]).attr('selected', is_active).text(text) );

	    });

	})(jQuery);


</script>

<?php get_footer(); ?>