<?php
/**
 * The Template for displaying all seller artworks.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
global $wp_query;

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$user_meta = get_user_meta( $store_user->ID );

//var_dump($wp_query->query_vars);

$following = unserialize($user_meta['_userpro_following_ids'][0]);
$followers = unserialize($user_meta['_userpro_followers_ids'][0]);

//var_dump()

if(!isset($user_meta['_userpro_following_ids'][0])){
	$following = [];
}

if(!isset($user_meta['_userpro_followers_ids'][0])){
	$followers = [];
}

$scheme = is_ssl() ? 'https' : 'http';
wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );
load_style('artists-style', 'artists-store.css');
load_js('artists-script', 'artists-store.js');


get_header();

?>

<?php $url = get_template_directory_uri() . '/assets/images/footer'; ?>


<?php echo do_shortcode('[userpro template=card user='.$store_user->user_login.']'); ?>



<div class="row user-info">

	<div class="col-md-3 avatar">
		<?=get_avatar( $store_user->ID, 280 )?>
	</div>

	<div class="col-md-9">
		<div class="row right follow-actions">
			<h4><small><?=_e('FOLLOWING', 'dokan')?></small> <?=count($following)?></h4>
			<h4><small><?=_e('FOLLOWERS', 'dokan')?></small> <?=count($followers)?></h4>
		</div>

		<div class="row">
			<div class="col-md-9 user-bio">
				<h1><?=$store_user->user_login?></h1>
				<p><?=nl2br($user_meta['description'][0])?></p>

				<?php /*Show Default Follow*/ if( ! is_user_logged_in() ): ?>
					<div class="userpro-sc-flw"><a href="<?=BASE_URL.'/my-account'?>" class="userpro-button secondary userpro-follow notfollowing" data-follow-text="Follow" data-unfollow-text="Unfollow" data-following-text="Following" data-follow-to="4" data-follow-from="1" id="fb-post-data" data-fbappid="" data-message="" data-caption="" data-link="" data-name="" data-description=""><i class="userpro-icon-share"></i>Follow</a></div>
				<?php endif; ?>

			</div>

			<div class="col-md-3 right user-stat">

				<!--Artwork Count-->
				<h1> <span class="artwork-count"><?=count_artwork($store_user->ID)?></span> <small><?=_e('ARTWORK', 'dokan')?></small></h1>

					<div class="socials">
					<a href="#"><span class="ib-social"></span></a>
					<a href="#"><span class="ib-social instagram"></span></a>
					<a href="#"><span class="ib-social twitter"></span></a>
					<a href="#"><span class="ib-social pinterest"></span></a>
					<a href="#"><span class="ib-social heart"></span></a>
				</div>
			</div>
		</div>
	</div>





</div>


<?php get_sidebar( 'store' ); ?>

    <div id="primary" class="content-area dokan-single-store col-md-9">
        <div id="content" class="site-content store-page-wrap woocommerce" role="main">
			<div class="seller-items">

				<?php
				       $args = array( 'post_type' => 'product', 'posts_per_page' => 6 );

                       if(isset($_GET['collection']) && $_GET['collection']){
                            $args = array( 'post_type' => 'product',
                                            'posts_per_page' => 6,
                                            'author'=>$store_user->ID,
	                            'tax_query' => array(
												array(
													'taxonomy' => 'product_tag',
													'terms'    => $_GET['collection'],
												),
											)
                                        );

                       }

                       $loop = new WP_Query( $args );
				 ?>

                <?php $art_count = 0; woocommerce_product_loop_start();  ?>

                    <?php while ( $loop->have_posts() ) : $loop->the_post();  ?>

                        <?php wc_get_template_part( 'content', 'store-product' ); ?>

                    <?php endwhile; wp_reset_query();  // end of the loop.  ?>

                <?php woocommerce_product_loop_end(); ?>
            </div>


            <?php if($wp_query->query_vars['taxonomy'] != 'product_cat'): ?>
	            <h1 class="nice2"><?=_e('LATEST', 'dokan')?></h1>
	            <div class="latest-artwork">
	                    <?=do_shortcode('[recent_products per_page="5" columns="6"]')?>
				</div>
            <?php endif; ?>

        </div>
    </div>

<!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>