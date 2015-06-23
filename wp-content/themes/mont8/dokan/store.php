<?php
/**
 * The Template for displaying all single posts.
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */

$store_user = get_userdata( get_query_var( 'author' ) );
$store_info = dokan_get_store_info( $store_user->ID );

$scheme = is_ssl() ? 'https' : 'http';
wp_enqueue_script( 'google-maps', $scheme . '://maps.google.com/maps/api/js?sensor=true' );

$user_meta = get_user_meta( get_current_user_id() );
var_dump($store_info);
get_header();



?>

<?php $url = get_template_directory_uri() . '/assets/images/footer'; ?>



<?php get_sidebar( 'store' ); ?>

    <div id="primary" class="content-area dokan-single-store col-md-9">
        <div id="content" class="site-content store-page-wrap woocommerce" role="main">



        </div>
    </div>

<!-- #content .site-content -->
</div><!-- #primary .content-area -->

<?php get_footer(); ?>