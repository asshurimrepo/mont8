<?php
/**
 * The Template for displaying a full width page.
 *
 * Template Name: Seller Dashboard
 *
 * @package dokan
 * @package dokan - 2013 1.0
 */

get_header();


?>

<div class="content-area">
	<div class="site-content">
	<div class="dokan-dashboard">
		<div class="dokan-dashboard-wrap">
		    <?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => get_query_var('pagename') ) ); ?>

		    <div class="dokan-dashboard-content">
		    
			<?php while (have_posts()) : the_post(); ?>

				<h1 class="nice"><?php the_title(); ?></h1>
		        <?php the_content(); ?>

		    <?php endwhile; ?>
		        
		    </div><!-- #primary .content-area -->
		</div>
	</div>
</div>
</div>



<?php get_footer(); ?>