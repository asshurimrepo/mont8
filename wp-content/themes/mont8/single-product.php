<?php

	/**
	 * The Template for displaying all single products.
	 *
	 * @package Dokan
	 * @subpackage WooCommerce/Templates
	 * @version 1.6.4
	 */


	load_product_page_assets();


	get_header();


	global $product;
	$meta = get_post_meta($product->id);

	$is_private = $meta['_visibility'][0] == 'hidden' ?: false;


	if ( ! $is_private )
	{
		get_template_part( 'single-product', 'online' );
	}
	else
	{
		get_template_part( 'single-product', 'private' );
	}


	get_footer();