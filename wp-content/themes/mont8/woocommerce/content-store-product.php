<?php
	/**
	 * The template for displaying product content within loops.
	 *
	 * Override this template by copying it to yourtheme/woocommerce/content-product.php
	 *
	 * @author 		WooThemes
	 * @package 	WooCommerce/Templates
	 * @version     1.6.4
	 */

	if ( ! defined( 'ABSPATH' ) ) {
		exit; // Exit if accessed directly
	}

	global $product, $woocommerce_loop;

	// Store loop count we're currently on
	if ( empty( $woocommerce_loop['loop'] ) )
		$woocommerce_loop['loop'] = 0;

	// Store column count for displaying the grid
	if ( empty( $woocommerce_loop['columns'] ) )
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );

	// Ensure visibility
	if ( ! $product || ! $product->is_visible() )
		return;

	$poster_markup = get_user_meta($product->post->post_author, '_poster_markup', true);

	// Increase loop count
	$woocommerce_loop['loop']++;

	$poster_markup = get_post_meta($product->id, '_poster_markup', true);
	$base_price = get_base_price('poster');
	$markup_price = $base_price[0] * ($poster_markup/100);
	$preview_price = get_woocommerce_currency_symbol().($base_price[0] + $markup_price);
?>

<li class="col-md-4 product-item">

		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<a href="<?php the_permalink(); ?>">
			<div class="photography">
				<?php

					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</div>

			<h3 class="shop_heading_text"><?php the_title(); ?>
				<small><?=$preview_price?></small>
			</h3>

			<?php

				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

		</a>

	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
		do_action( 'woocommerce_after_shop_loop_item' );

	?>

</li>
