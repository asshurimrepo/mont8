<?php
	$store_user   = get_userdata( get_query_var( 'author' ) );
	$store_info   = get_user_meta( $store_user->ID, 'dokan_profile_settings', true );
	$map_location = isset( $store_info['location'] ) ? esc_attr( $store_info['location'] ) : '';

//	var_dump( get_prouct_tags() );
?>

<div id="secondary" class="col-md-3 clearfix" role="complementary">
	<button type="button" class="navbar-toggle widget-area-toggle" data-toggle="collapse" data-target=".widget-area">
		<i class="fa fa-bars"></i>
		<span class="bar-title"><?php _e( 'Toggle Sidebar', 'dokan' ); ?></span>
	</button>

	<div class="widget-area collapse widget-collapse">


		<aside class="widget product-tags dokan-clearfix"><h3 class="widget-title">View Collections</h3>

			<div class="tagcloud">

				<?php foreach ( get_prouct_tags() as $tags ): ?>

					<a href="<?= BASE_URL ?>/store/<?= $store_info['store_name'] ?>/?collection=<?= $tags->term_id ?>"
					   title="<?= $tags->name ?>" style="font-size: 22pt;">
						<?= $tags->name ?>
					</a>

				<?php endforeach; ?>
		</aside>


		<?php do_action( 'dokan_sidebar_store_after', $store_user, $store_info ); ?>
	</div>
	<div class="clearfix"></div>
</div><!-- #secondary .widget-area -->