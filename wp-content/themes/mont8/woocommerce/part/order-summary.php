<?php
	/**
	 * Customer processing order email
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates/Emails
	 * @version     1.6.4
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	$recipient = $order->billing_first_name . ' ' . $order->billing_last_name;

?>

<table class="table table-bordered">
	<thead>
	<tr>
		<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce' ); ?></th>
		<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
		<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
	</tr>
	</thead>
	<tbody>
	<?php echo $order->email_order_items_table( $order->is_download_permitted(), true, $order->has_status( 'processing' ) ); ?>
	</tbody>
	<tfoot>
	<?php
		if ( $totals = $order->get_order_item_totals() )
		{
			$i = 0;
			foreach ( $totals as $total )
			{
				$i ++;
				?>
				<tr>
				<th scope="row" colspan="2" style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 )
				{
					echo 'border-top-width: 4px;';
				} ?>"><?php echo $total['label']; ?></th>
				<td style="text-align:left; border: 1px solid #eee; <?php if ( $i == 1 )
				{
					echo 'border-top-width: 4px;';
				} ?>"><?php echo $total['value']; ?></td>
				</tr><?php
			}
		}
	?>
	</tfoot>
</table>

