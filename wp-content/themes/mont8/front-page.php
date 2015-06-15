<?php
/**
 * The main template file for homepage.
 *
 * This is the most generic template file in a WordPress theme
 * and one of the two required files for a theme (the other being style.css).
 * It is used to display a page when nothing more specific matches a query.
 * E.g., it puts together the home page when no home.php file exists.
 * Learn more: http://codex.wordpress.org/Template_Hierarchy
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
get_header();
?>

<div id="primary" class="home-content-area col-md-12">
    <div id="content" class="site-content" role="main">
        

        <div class="row">
            <!--<div class="col-md-4">
                <?php //dokan_category_widget(); ?>
            </div>-->

            <div class="col-md-12">
                <?php putRevSlider( "slider" ) ?>
            </div>
        </div> <!-- #home-page-section-1 -->
        
        
        <!--Popular Product-->
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-lg-12 content_padding">
            	<h1 class="entry-title">Popular Products</h1>
                <p class="subtitle">Designed and manufactured in-house since 2006. The world's most talented artists and biggest brands<br/>trust us to make their artwork pop</p>
            </div>
            
            <div class="popular_products col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
            	<div class="col-xs-12 col-sm-6 col-lg-5 fade-effect">
                	<a href="<?=get_site_url()?>/product-tag/framed-art/"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/framed_art_pic.jpg" class="img-responsive center-block" alt="" /></a>
                </div>
                
                <div class="col-xs-12 col-sm-7 col-lg-7" style="padding:0">
                    <div class="col-xs-12 col-sm-6 col-lg-6 fade-effect">
                        <a href="<?=get_site_url()?>/product-tag/photography/"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/photography_pic.jpg" class="img-responsive center-block" alt="" /></a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 fade-effect">
                        <a href="<?=get_site_url()?>/product-tag/stretched-canvases/"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/canvas_pic.jpg" class="img-responsive center-block" alt="" /></a>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-lg-6 fade-effect">
                        <a href="<?=get_site_url()?>/product-tag/fine-art/"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/art_print_pic.jpg" class="img-responsive center-block" alt="" /></a>
                    </div>
                     <div class="col-xs-12 col-sm-6 col-lg-6 fade-effect">
                        <a href="<?=get_site_url()?>/product-tag/posters/"><img src="<?php echo get_stylesheet_directory_uri() ?>/assets/images/poster_pic.jpg" class="img-responsive center-block" alt="" /></a>
                    </div> 
                </div>    
            
            </div>            
        </div>
        
         <!--Shop the Gallery-->
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-lg-12  section_padding">
            	<h1 class="entry-title">Shop The Gallery</h1>
                <p class="subtitle">Shop among 20,000 arts from the best artists in the world which can make your place whether it’s<br/>home, office looks better</p>
            </div>
            <div class="col-xs-12 col-sm-12 col-lg-12">
            	<?php echo do_shortcode( '[recent_products per_page="20" columns="4"]' );?>            	
            </div>                       
        </div>


		
        
         <!--Blog-->
        <div class="row">
        	<div class="col-xs-12 col-sm-12 col-lg-12 content_padding">
            	<h1 class="entry-title">From the Blog</h1>
                <p class="subtitle">Art, life, work and play at Mont8.</p>
            </div>
            
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            
            	
                <?php query_posts("posts_per_page=20&cat=49");while (have_posts()) : the_post(); ?>    
                <div class="col-xs-12 col-sm-6 col-lg-6">
                    <div class="blog">
                        <?php the_post_thumbnail();?>
                        <h2 class="blog_title"><?php the_title();?></h2>
                        <a href="<?php the_permalink() ?>" class="btn btn-default btn-readmore">Read More</a>
                    </div>
                </div>
                <?php endwhile; ?>
            
            </div>            
        </div>


        

         

        

    </div><!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>