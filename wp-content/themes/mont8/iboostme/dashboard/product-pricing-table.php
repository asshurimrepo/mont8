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
		'framed_print' => [
			'id'      => '_framed_print_markup',
			'image'   => 'product-FP.jpg',
			'label'   => 'Framed Print',
			'slug'    => 'framed-art',
			'default' => $_framed_print_markup
		],
		'art_print'    => [
			'id'      => '_art_print_markup',
			'image'   => 'product-PO.jpg',
			'label'   => 'Art Print',
			'slug'    => 'art-print',
			'default' => $_art_print_markup
		],
		'photo_print'  => [
			'id'      => '_photo_print_markup',
			'image'   => 'product-PO.jpg',
			'label'   => 'Photo Print',
			'slug'    => 'photography',
			'default' => $_photo_print_markup
		],
		'canvas'       => [
			'id'      => '_canvas_markup',
			'image'   => 'product-S.jpg',
			'label'   => 'Canvas',
			'slug'    => 'stretched-canvases',
			'default' => $_canvas_markup
		],
		'poster'       => [
			'id'      => '_poster_markup',
			'image'   => 'product-PO.jpg',
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

	foreach ( $art_products as $id => $art )
	{
		$base_price[ $id ][2] = $base_price[ $id ][0] * ( .1 + ( $art['default'] / 100 ) );
	}
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
		<tr id="pricing-<?=$art['slug']?>">
			<td><img src="<?= get_image( $art['image'] ) ?>" class="img-responsive"></td>
			<td><?= $art['label'] ?></td>
			<td class="hide_in_product"><?= $base_price[ $id ][0] ?> AED - <?= $base_price[ $id ][1] ?> AED</td>
			<td class="hide_in_product"><?= $base_price[ $id ][2] ?> AED - <?= $base_price[ $id ][0] ?> AED</td>
			<td class="hide_in_product"><?= $base_price[ $id ][2] ?> AED</td>
			<td>
				<input type="number" name="<?= $art['id'] ?>" class="form-control right"
				       value="<?= $_post_meta[ $art['id'] ][0] ?: $art['default'] ?>">
			</td>
		</tr>

	<?php endforeach; ?>


	</tbody>
</table>