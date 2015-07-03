<?php
	$featured_products = get_the_author_meta( 'featured_products', get_current_user_id() );
	$labels = [
		'framed-art'  => 'Framed Art',
		'art-print'   => 'Art Print',
		'photo-print' => 'Photography',
		'poster'      => 'Posters',
		'canvas'      => 'Stretched Canvas',
	];
?>



<h1 style="padding-top: 0; margin-top: 0;">Featured Products</h1>

<div class="row featured-products">

	<?php $i=0; foreach($featured_products as $key=>$featured): ?>

		<div class="col-md-4">
			<div class="featured <?=$key?>">
				<?php
					echo wp_get_attachment_image( $featured_products[ $key ], 'shop_single', null, [ 'class' => 'img-responsive', ] );
				?>
			</div>
			<h3 style="text-align: center"><?=$labels[$key]?></h3>
		</div>

		<?php if ( $i % 3 == 2 ): ?>
			<div class="col-md-12">
				<hr/></div>
		<?php endif; ?>

	<?php $i++; endforeach; ?>

</div>
