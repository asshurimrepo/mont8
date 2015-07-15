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
			'label'   => 'Fine Art Print',
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

	$currency_rate = get_current_currency('rate');
	$currency_name = get_current_currency('name');

	foreach ( $art_products as $id => $art )
	{

		$base_price[ $id ][2] = $base_price[ $id ][0] + ( $base_price[ $id ][0] * ($art_products[$id]['default']/100) );
		$base_price[ $id ][3] = $base_price[ $id ][1] + ( $base_price[ $id ][1] * ($art_products[$id]['default']/100) );
		$base_price[ $id ][2] *= $currency_rate;
		$base_price[ $id ][3] *= $currency_rate;
		$base_price[ $id ][0] *= $currency_rate;
		$base_price[ $id ][1] *= $currency_rate;
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

		<?php
			$margin_min = $base_price[ $id ][0] * ($art_products[$id]['default']/100);
			$margin_max = $base_price[ $id ][1] * ($art_products[$id]['default']/100);

			//Apply Rate
			$margin_min *= $currency_rate;
			$margin_max *= $currency_rate;
		?>

		<tr id="pricing-<?=$art['slug']?>">
			<td><img src="<?= get_image( $art['image'] ) ?>" class="img-responsive"></td>
			<td><?= $art['label'] ?></td>
			<td class="hide_in_product"><?= round($base_price[ $id ][0]) ?> <?=$currency_name?> - <?= round($base_price[ $id ][1]) ?> <?=$currency_name?></td>
			<td class="hide_in_product"><?= round($margin_min) ?> <?=$currency_name?> - <?= round($margin_max) ?> <?=$currency_name?></td>
			<td class="hide_in_product"><?= round($base_price[ $id ][2]) ?> <?=$currency_name?> - <?= round($base_price[ $id ][3]) ?> <?=$currency_name?></td>
			<td>
				<input type="number" name="<?= $art['id'] ?>" class="form-control right"
				       value="<?= $_post_meta[ $art['id'] ][0] ?: $art['default'] ?>">
			</td>
		</tr>

	<?php endforeach; ?>


	</tbody>
</table>