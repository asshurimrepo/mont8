<?php
	/**
	 * Cart Page
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     2.3.8
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	wc_print_notices();

	do_action( 'woocommerce_before_cart' ); ?>

<form action="<?php echo esc_url( WC()->cart->get_cart_url() ); ?>" method="post">

	<?php do_action( 'woocommerce_before_cart_table' ); ?>

	<table class="cart cart-table table" cellspacing="0">
		<thead>
		<tr>
			<th class="product-thumbnail">&nbsp;</th>
			<th class="product-name">&nbsp;</th>
			<th class="product-price"><?php _e( 'Unit', 'woocommerce' ); ?></th>
			<th class="product-quantity"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th class="product-subtotal"><?php _e( 'Item Total', 'woocommerce' ); ?></th>
			<th class="product-remove">&nbsp;</th>
		</tr>
		</thead>
		<tbody>
		<?php do_action( 'woocommerce_before_cart_contents' ); ?>

		<?php
			foreach ( WC()->cart->get_cart() as $cart_item_key => $cart_item )
			{
				$_product   = apply_filters( 'woocommerce_cart_item_product', $cart_item['data'], $cart_item, $cart_item_key );
				$product_id = apply_filters( 'woocommerce_cart_item_product_id', $cart_item['product_id'], $cart_item, $cart_item_key );

				if ( $_product && $_product->exists() && $cart_item['quantity'] > 0 && apply_filters( 'woocommerce_cart_item_visible', true, $cart_item, $cart_item_key ) )
				{
					?>
					<tr class="<?php echo esc_attr( apply_filters( 'woocommerce_cart_item_class', 'cart_item', $cart_item, $cart_item_key ) ); ?>">


						<td class="product-thumbnail">
							<?php
								$thumbnail = apply_filters( 'woocommerce_cart_item_thumbnail', $_product->get_image( 'shop_catalog', [ 'class' => 'img-responsive' ] ), $cart_item, $cart_item_key );

								if ( ! $_product->is_visible() )
								{
									echo $thumbnail;
								}
								else
								{
									printf( '<a href="%s">%s</a>', $_product->get_permalink( $cart_item ), $thumbnail );
								}
							?>
						</td>

						<td class="product-name">
							<h2><?= $_product->get_title() ?></h2>
							<?php
								echo WC()->cart->get_item_data( $cart_item );
							?>
						</td>

						<td class="product-price">
							<?php
								echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $_product ), $cart_item, $cart_item_key );
							?>
						</td>

						<td class="product-quantity">
							<?php
								if ( $_product->is_sold_individually() )
								{
									$product_quantity = sprintf( '1 <input type="hidden" name="cart[%s][qty]" value="1" />', $cart_item_key );
								}
								else
								{
									$product_quantity = woocommerce_quantity_input( array(
										'input_name'  => "cart[{$cart_item_key}][qty]",
										'input_value' => $cart_item['quantity'],
										'max_value'   => $_product->backorders_allowed() ? '' : $_product->get_stock_quantity(),
										'min_value'   => '0',
										'class'       => 'form-control',
									), $_product, false );
								}

								echo apply_filters( 'woocommerce_cart_item_quantity', $product_quantity, $cart_item_key );
							?>
						</td>

						<td class="product-subtotal">
							<?php
								echo apply_filters( 'woocommerce_cart_item_subtotal', WC()->cart->get_product_subtotal( $_product, $cart_item['quantity'] ), $cart_item, $cart_item_key );
							?>
						</td>

						<td class="product-remove">
							<a href="<?= esc_url( WC()->cart->get_remove_url( $cart_item_key ) ) ?>">remove</a>
						</td>
					</tr>
					<?php
				}
			}

			do_action( 'woocommerce_cart_contents' );
		?>
		<tr>
			<td colspan="6" class="actions">

				<?php if ( WC()->cart->coupons_enabled() )
				{ ?>
					<div class="coupon pull-right" style="display: block; text-align: right;">

						<span class="coupon-text"><i class="fa fa-credit-card"></i> <b><?php _e('GIFT CARD / PROMO CODE'); ?></b></span>
							<input type="text"
							       name="coupon_code"
							       class="coupon_input"
							       id="coupon_code"
							       value=""
							       placeholder="<?php _e( 'Coupon code', 'woocommerce' ); ?>"/>

							<input type="submit" class="btn btn-default btn-black" name="apply_coupon"
							       value="<?php _e( 'Apply Coupon', 'woocommerce' ); ?>"/>

							<?php do_action( 'woocommerce_cart_coupon' ); ?>

							<input type="submit" class="btn btn-default btn-black" name="update_cart"
							       value="<?php _e( 'Update Cart', 'woocommerce' ); ?>"/>
					</div>
				<?php } ?>


				<?php do_action( 'woocommerce_cart_actions' ); ?>

				<?php wp_nonce_field( 'woocommerce-cart' ); ?>
			</td>
		</tr>

		<?php do_action( 'woocommerce_after_cart_contents' ); ?>
		</tbody>
	</table>

	<?php do_action( 'woocommerce_after_cart_table' ); ?>

</form>

<div class="cart-collaterals">

	<?php do_action( 'woocommerce_cart_collaterals' ); ?>

</div>

<?php do_action( 'woocommerce_after_cart' ); ?>
