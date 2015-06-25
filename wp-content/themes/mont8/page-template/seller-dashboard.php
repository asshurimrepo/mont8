<?php
	/**
	 * The Template for displaying a full width page.
	 *
	 * Template Name: Seller Dashboard
	 *
	 * @package dokan
	 * @package dokan - 2013 1.0
	 */
	global $post;

	/*Restricted only for user logged in, otherwise redirect to login page*/
	if( ! is_user_logged_in() && $post->post_slug != 'my-account' ){
		header('redirect: '.BASE_URL.'/my-account');
	}

	get_header();


?>


	<?php if ( ! is_user_logged_in() ): ?>

	<div id="primary" class="content-area col-md-12">
		<div id="content" class="site-content" role="main">

			<?php while (have_posts()) : the_post(); ?>

				<?php get_template_part( 'content', 'page' ); ?>

				<?php
				// If comments are open or we have at least one comment, load up the comment template
				if ( comments_open() || '0' != get_comments_number() )
					comments_template( '', true );
				?>

			<?php endwhile; // end of the loop. ?>

		</div><!-- #content .site-content -->
	</div><!-- #primary .content-area -->

	<?php endif; ?>




<?php if ( is_user_logged_in() ): ?>
	<div class="content-area">
		<div class="site-content">
			<div class="dokan-dashboard">
				<div class="dokan-dashboard-wrap">
					<?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => get_query_var( 'pagename' ) ) ); ?>

					<div class="dokan-dashboard-content">

						<?php while ( have_posts() ) : the_post(); ?>

							<h1 class="nice"><?php the_title(); ?></h1>
							<?php the_content(); ?>

						<?php endwhile; ?>

					</div>
					<!-- #primary .content-area -->
				</div>
			</div>
		</div>
	</div>
<?php endif; ?>

<?php get_footer(); ?>