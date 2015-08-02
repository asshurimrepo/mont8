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
		'framed_print' => [ 19.06, 86.85 ],
		'art_print'    => [ 8.98, 46.28 ],
		'photo_print'  => [ 10.35, 53.09 ],
		'canvas'       => [ 49.28, 113.25 ],
		'poster'       => [ 14.70, 24.50 ]
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

		$base_price[ $id ][2] = $base_price[ $id ][0] + ( $margin_min );
		$base_price[ $id ][3] = $base_price[ $id ][1] + ( $margin_max );




		/*			//Apply Rate
					$margin_min *= $currency_rate;
					$margin_max *= $currency_rate;*/
		?>

		<tr id="pricing-<?= $art['slug'] ?>">
			<td><img src="<?= get_image( $art['image'] ) ?>" style="max-width: 150px;" class="img-responsive"></td>
			<td><?= $art['label'] ?></td>
			<td class="hide_in_product">
				<?= $currency_name ?> <?= number_format( $base_price[ $id ][0], 2 ) ?>
				-
				<?= $currency_name ?> <?= number_format( $base_price[ $id ][1], 2 ) ?>
			</td>

			<td class="hide_in_product">
				<?= $currency_name ?> <?= number_format( $margin_min, 2 ) ?>
				-
				<?= $currency_name ?> <?= number_format( $margin_max, 2 ) ?>
			</td>

			<td class="hide_in_product">
				<?= $currency_name ?> <?= number_format( $base_price[ $id ][2], 2 ) ?>
				-
				<?= $currency_name ?> <?= number_format( $base_price[ $id ][3], 2 ) ?></td>
			<td>
				<input min="0" max="100" type="number" name="<?= $art['id'] ?>" class="form-control markup-field right"
				       value="<?= $_post_meta[ $art['id'] ][0] ?: $art['default'] ?>">
			</td>
		</tr>

	<?php endforeach; ?>

	</tbody>
</table>

<script>
	jQuery(document).ready(function ($) {

		$("input.markup-field").change(function () {

			$(this).val($(this).val() < 0 ? 0 : $(this).val());
			$(this).val($(this).val() > 100 ? 100 : $(this).val());

		});

	});
</script>