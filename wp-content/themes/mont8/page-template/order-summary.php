<?php
	/**
	 * The Template for displaying a full width page.
	 *
	 * Template Name: Order Summary Page
	 *
	 * @package dokan
	 * @package dokan - 2013 1.0
	 */

	load_style( 'order-summary-style', 'order-summary.css' );
	load_js( 'js-cookie-script', 'js.cookie.js' );
	load_js( 'jquery-validate', 'jquery-validate.js' );
	load_js( 'order-summary-script', 'order-summary.js' );

	get_header();
?>

	<div id="primary" class="content-area col-md-12">
		<div id="content" class="site-content" role="main">

			<?php while ( have_posts() ) : the_post(); ?>

				<?php get_template_part( 'content', 'order-summary' ); ?>

			<?php endwhile; // end of the loop. ?>

		</div>
		<!-- #content .site-content -->
	</div><!-- #primary .content-area -->

<?php get_footer(); ?>