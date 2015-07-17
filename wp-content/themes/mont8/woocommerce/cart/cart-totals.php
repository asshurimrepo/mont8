<?php
	/**
	 * Cart totals
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     2.3.6
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit;
	}
	$packages = WC()->cart->get_shipping_packages();
	$total_weight = MontWeightCalculator::set($packages[0]['contents'])->getTotalWeights();
//	var_dump($total_weight);

?>
<div class="cart_totals <?php if ( WC()->customer->has_calculated_shipping() )
{
	echo 'calculated_shipping';
} ?>">

	<?php do_action( 'woocommerce_before_cart_totals' ); ?>

	<p style="text-align: right; font-size: 20px;">
		<?=__('Total Weights', 'woocommerce')?>: <b><?=$total_weight?> KG</b>
		<br />
		<?php
			;
			if ( WC()->cart->get_cart_shipping_total() &&  WC()->cart->needs_shipping() && WC()->cart->show_shipping() ):
				wc_cart_totals_shipping_html();
			endif;
		?>
	</p>

	<h2 style="text-align: right; font-size: 30px; margin: 0;">
		<small><?php _e( 'TOTAL', 'woocommerce' ); ?> </small><?php wc_cart_totals_order_total_html(); ?>
		<a style="margin-top: 0;" href="#" data-step="2"
		   class="cart-sidebar-btn-checkout btn btn-primary btn-lg"><?= __( 'Next', 'dokan' ) ?> <i
				class="fa fa-angle-double-right"></i></a>
	</h2>


	<table cellspacing="0">


		<?php foreach ( WC()->cart->get_coupons() as $code => $coupon ) : ?>
			<tr class="cart-discount coupon-<?php echo esc_attr( $code ); ?>">
				<th><?php wc_cart_totals_coupon_label( $coupon ); ?></th>
				<td><?php wc_cart_totals_coupon_html( $coupon ); ?></td>
			</tr>
		<?php endforeach; ?>

	</table>


</div>
