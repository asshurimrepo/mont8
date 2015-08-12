<?php
	/**
	 * Email Order Items
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates/Emails
	 * @version     2.1.2
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	$currency = get_current_currency();


	$c_left  = in_array( $currency['position'], [ 'left', 'left_space' ] ) ? $currency['symbol'] : '';
	$c_right = in_array( $currency['position'], [ 'right', 'right_space' ] ) ? $currency['symbol'] : '';


	foreach ( $items as $item_id => $item ) :
		$item_meta   = unserialize( $item['item_meta']['_tmcartepo_data'][0] );
		$product     = new WC_Product( $item['product_id'] );
		$store_url   = dokan_get_store_url( $product->post->post_author );
		$seller_info = dokan_get_store_info( $product->post->post_author );

		?>

		<tr>
			<td>
				<h3><?= $item['name'] ?></h3>
				<table style="border: none; width: 100%" class="table">
					<tr>
						<td style="padding: 2px; text-align:left; border: 1px solid #eee;">
							<b>Seller</b>:
						</td>
						<td style="padding: 2px; text-align:left; border: 1px solid #eee;">
							<a href="<?= $store_url ?>"><?= $seller_info['store_name'] ?></a>
						</td>
					</tr>
					<?php
						foreach ( $item_meta as $meta )
						{

							if ( in_array( $meta['value'], [ 'Seller Markup', 'Yes' ] ) )
							{
								continue;
							}

							echo "
						<tr>
						<td style='padding: 2px; text-align:left; border: 1px solid #eee;'><b>{$meta['name']}:</b></td>
						<td style='padding: 2px; text-align:left; border: 1px solid #eee;'>{$meta['value']}</td>
						</tr>
						";
						}
					?>
				</table>
			</td>
			<td style="vertical-align: middle; text-align: center;"><?= $item['qty'] ?></td>
			<td style="vertical-align: middle; text-align: center;"><?= $c_left . $item['line_total'] . $c_right ?></td>
		</tr>

	<?php endforeach; ?>
