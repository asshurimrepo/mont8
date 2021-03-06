<?php
	/**
	 * Customer invoice email
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates/Emails
	 * @version     2.2.0
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>


	Hello there <?= esc_html( $user_login ) ?>!
	<br/><br/>
	We’re ecstatic you are joining us in spreading inspiration of awesome artists to the Middle East!
	We are delighted to tell you that your order has been submitted and is in the queue to be processed and shipped within 1-5 business days
	<br/>

<?php do_action( 'woocommerce_email_before_order_table', $order, $sent_to_admin, $plain_text ); ?>

	<h2><?php printf( __( 'Order #%s', 'woocommerce' ), $order->get_order_number() ); ?>
		(<?php printf( '<time datetime="%s">%s</time>', date_i18n( 'c', strtotime( $order->order_date ) ), date_i18n( wc_date_format(), strtotime( $order->order_date ) ) ); ?>
		)</h2>

	<table cellspacing="0" cellpadding="6" style="width: 100%; border: 1px solid #eee;" border="1" bordercolor="#eee">
		<thead>
		<tr>
			<th scope="col"
			    style="text-align:left; border: 1px solid #eee;"><?php _e( 'Product', 'woocommerce' ); ?></th>
			<th scope="col"
			    style="text-align:left; border: 1px solid #eee;"><?php _e( 'Quantity', 'woocommerce' ); ?></th>
			<th scope="col" style="text-align:left; border: 1px solid #eee;"><?php _e( 'Price', 'woocommerce' ); ?></th>
		</tr>
		</thead>
		<tbody>
		<?php
			switch ( $order->get_status() )
			{
				case "completed" :
					echo $order->email_order_items_table( $order->is_download_permitted(), false, true );
					break;
				case "processing" :
					echo $order->email_order_items_table( $order->is_download_permitted(), true, true );
					break;
				default :
					echo $order->email_order_items_table( $order->is_download_permitted(), true, false );
					break;
			}
		?>
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

	<br><br>
	For all of your questions, comments, or concerns please read out <a
	href="http://mont8.com/staging/faqs/">FAQs</a> or contact us <a
	href="http://mont8.com/staging/contact-us/">here</a>, we would be glad to assist you.
	Thank you a million times for your order!
	<br><br>
	The Mont8 Family


<?php do_action( 'woocommerce_email_after_order_table', $order, $sent_to_admin, $plain_text ); ?>

<?php do_action( 'woocommerce_email_order_meta', $order, $sent_to_admin, $plain_text ); ?>

<?php do_action( 'woocommerce_email_footer' ); ?>