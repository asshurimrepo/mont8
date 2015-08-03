<?php


	add_filter( 'woocommerce_order_item_product', 'mont8_order_item_product', 10, 2 );

	function mont8_order_item_product( $product, $item )
	{
		/*var_dump( $product );
		var_dump( $item );*/
	}