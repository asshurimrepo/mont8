<?php
	if ( ! isset( $_post_meta ) )
	{
		$_post_meta = [ ];
	}

	$global_pricing = new GlobalPricing( get_current_user_id() );

	$_framed_print_markup = $global_pricing->get_markup( 'framed_print' );
	$_art_print_markup    = $global_pricing->get_markup( 'art_print' );
	$_photo_print_markup  = $global_pricing->get_markup( 'photo_print' );
	$_canvas_markup       = $global_pricing->get_markup( 'canvas' );
	$_poster_markup       = $global_pricing->get_markup( 'poster' );


	$art_products = [
		'art_print'    => [
			'id'      => '_art_print_markup',
			'image'   => 'product-AP.jpg',
			'label'   => 'Fine Art Print',
			'slug'    => 'art-print',
			'default' => $_art_print_markup
		],
		'photo_print'  => [
			'id'      => '_photo_print_markup',
			'image'   => 'product-PP.jpg',
			'label'   => 'Photo Print',
			'slug'    => 'photography',
			'default' => $_photo_print_markup
		],
		'framed_print' => [
			'id'      => '_framed_print_markup',
			'image'   => 'product-FP.jpg',
			'label'   => 'Framed Print',
			'slug'    => 'framed-art',
			'default' => $_framed_print_markup
		],
		'canvas'       => [
			'id'      => '_canvas_markup',
			'image'   => 'product-C.jpg',
			'label'   => 'Stretched Canvas',
			'slug'    => 'stretched-canvases',
			'default' => $_canvas_markup
		],
		'poster'       => [
			'id'      => '_poster_markup',
			'image'   => 'product-P.jpg',
			'label'   => 'Poster',
			'slug'    => 'posters',
			'default' => $_poster_markup
		]
	];

	$base_price = [
		'framed_print' => [ 70, 319 ],
		'art_print'    => [ 33, 170 ],
		'photo_print'  => [ 38, 195 ],
		'canvas'       => [ 181, 564 ],
		'poster'       => [ 54, 90 ]
	];

	$currency_rate = get_current_currency( 'rate' );
	$currency_name = get_current_currency( 'name' );

?>

<table class="table">
	<thead>
	<tr>
		<th class="col-md-2">Product</th>
		<th></th>
		<th class="hide_in_product">Base Price</th>
		<th class="hide_in_product">Your Margin</th>
		<th class="hide_in_product">Retail Price</th>
		<th style="width: 13%;" class="right">Markup (%)</th>
	</tr>
	</thead>

	<tbody>


	<?php foreach ( $art_products as $id => $art ): ?>

		<?php

		$base_price[ $id ][0] *= $currency_rate;
		$base_price[ $id ][1] *= $currency_rate;

		$base_price[ $id ][2] *= $currency_rate;
		$base_price[ $id ][3] *= $currency_rate;

		$margin_min = $base_price[ $id ][0] * ( $art_products[ $id ]['default'] / 100 );
		$margin_max = $base_price[ $id ][1] * ( $art_products[ $id ]['default'] / 100 );

		$base_price[ $id ][2] = ceil($base_price[ $id ][0]) + ( $margin_min );
		$base_price[ $id ][3] = $base_price[ $id ][1] + ( $margin_max );




		/*			//Apply Rate
					$margin_min *= $currency_rate;
					$margin_max *= $currency_rate;*/
		?>

		<tr id="pricing-<?= $art['slug'] ?>">
			<td><img src="<?= get_image( $art['image'] ) ?>" class="img-responsive"></td>
			<td><?= $art['label'] ?></td>
			<td class="hide_in_product"><?= ceil( $base_price[ $id ][0] ) ?> <?= $currency_name ?>
				- <?= ceil( $base_price[ $id ][1] ) ?> <?= $currency_name ?></td>
			<td class="hide_in_product"><?= ceil( $margin_min ) ?> <?= $currency_name ?>
				- <?= ceil( $margin_max ) ?> <?= $currency_name ?></td>
			<td class="hide_in_product"><?= ceil( $base_price[ $id ][2] ) ?> <?= $currency_name ?>
				- <?= ceil( $base_price[ $id ][3] ) ?> <?= $currency_name ?></td>
			<td>
				<input type="number" name="<?= $art['id'] ?>" class="form-control right"
				       value="<?= $_post_meta[ $art['id'] ][0] ?: $art['default'] ?>">
			</td>
		</tr>

	<?php endforeach; ?>


	</tbody>
</table>

<div class="row">
	<div class="col-md-12">
		Click <a href="?p=412">here</a> to know more about our products
	</div>
</div>