<?php
/**
 * Cart item data (when outputting non-flat)
 *
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version 	2.1.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

?>
<dl class="variation">
	<?php

		foreach ( $item_data as $data ){
			$key = sanitize_text_field( $data['key'] );
			if($key == 'Frame this print'){
				$is_framed = true;
			}
		}


		foreach ( $item_data as $data ) :
			$key = sanitize_text_field( $data['key'] );
			if ($key == 'Artwork Style' && $is_framed){
				$data['value'] = 'Framed '.$data['value'];
			}
	?>
		<dt class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( $data['key'] ); ?>:</dt>
		<dd class="variation-<?php echo sanitize_html_class( $key ); ?>"><?php echo wp_kses_post( wpautop( $data['value'] ) ); ?></dd>
	<?php endforeach; ?>
</dl>
