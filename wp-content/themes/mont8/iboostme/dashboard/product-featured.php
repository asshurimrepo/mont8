<?php

	load_js( 'featured-products', 'featured-product.js' );
	load_style( 'featured-products', 'featured-products.css' );
	wp_enqueue_media();

	$response          = User_Actions::listens();
	$featured_products = get_the_author_meta( 'featured_products', get_current_user_id() );

	//	var_dump( $featured_products );

	$featured_inputs = [
		'framed-art'  => 'Framed Art',
		'art-print'   => 'Art Print',
		'photo-print' => 'Photography',
		'poster'      => 'Posters',
		'canvas'      => 'Stretched Canvas',
	];

	$profile_info = dokan_get_store_info( get_current_user_id() );
	$gravatar     = isset( $profile_info['gravatar'] ) ? absint( $profile_info['gravatar'] ) : 0;

?>



<?php if ( isset( $response['message'] ) ): ?>
	<div class="dokan-alert dokan-alert-success">
		<a class="dokan-close" data-dismiss="alert">&times;</a>

		<strong><?php _e( 'Success!', 'dokan' ); ?></strong> <?php echo $response['message'] ?>.<br>

	</div>
<?php endif; ?>


<p><?= __( 'From this page you can pick a display picture for each of your available for sale products.', 'dokan' ) ?>
	<br/> <?= __( 'Mix & Match your pictures to make your store visually exciting.', 'dokan' ) ?></p>


<form method="post" class="row featured-cont">

	<?php $i = 0;
		foreach ( $featured_inputs as $index => $item_name ): ?>
			<div class="col-md-4">
				<a href="#!" class="dropzone uploader row--popsbear dz-clickable">

					<div class="featured">
						<?php
							if ( isset( $featured_products[ $index ] ) && $featured_products[ $index ] )
							{
								echo wp_get_attachment_image( $featured_products[ $index ], 'shop_catalog', null, [ ] );
							}
							else
							{
								echo '<img />';
							}
						?>
					</div>

					<input type="hidden" name="items[<?= $index ?>]" value="<?= $featured_products[ $index ] ?>"/>

					<i class="fa fa-cloud-upload"></i>
				</a>

				<h3><?= $item_name ?></h3>
			</div>

			<?php if ( $i % 3 == 2 ): ?>
				<div class="col-md-12">
					<hr/>
				</div>
			<?php endif; ?>

			<?php $i ++; endforeach; ?>


	<div class="col-md-12 ">
		<input type="submit" name="set_featured_products" class="dokan-btn pull-right dokan-btn-danger dokan-btn-theme"
		       value="Save Changes">
	</div>

</form>
