<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );
$user_meta = get_user_meta( $store_user->ID );

//var_dump($user_meta);

$following = unserialize($user_meta['_userpro_following_ids'][0]);
$followers = unserialize($user_meta['_userpro_followers_ids'][0]);

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
			</div>

			<div class="col-md-3 right user-stat">
				<h1> <span class="artwork-count">0</span> <small><?=_e('ARTWORK', 'dokan')?></small></h1>
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

                <?php $art_count = 0; woocommerce_product_loop_start();  ?>

                    <?php while ( have_posts() ) : the_post(); $art_count += 1; ?>

                        <?php wc_get_template_part( 'content', 'store-product' ); ?>

                    <?php endwhile; // end of the loop. ?>

                <?php woocommerce_product_loop_end(); ?>
				<span class="art-count hide"><?=$art_count?></span>
            </div>

        </div>
    </div>

<!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>