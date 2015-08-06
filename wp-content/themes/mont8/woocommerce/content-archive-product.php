<?php
	/**
	 * The template for displaying product content within loops.
	 *
	 * Override this template by copying it to yourtheme/woocommerce/content-product.php
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     1.6.4
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	global $product, $woocommerce_loop, $wp_query;

	// Store loop count we're currently on
	if ( empty( $woocommerce_loop['loop'] ) )
	{
		$woocommerce_loop['loop'] = 0;
	}

	// Store column count for displaying the grid
	if ( empty( $woocommerce_loop['columns'] ) )
	{
		$woocommerce_loop['columns'] = apply_filters( 'loop_shop_columns', 3 );
	}

	// Ensure visibility
	if ( ! $product || ! $product->is_visible() )
	{
		return;
	}

	// Increase loop count
	$woocommerce_loop['loop'] ++;

	Share::setData( $product );

	// Extra post classes
	$classes = array();
	if ( 0 == ( $woocommerce_loop['loop'] - 1 ) % $woocommerce_loop['columns'] || 1 == $woocommerce_loop['columns'] )
	{
		$classes[] = 'first';
	}
	if ( 0 == $woocommerce_loop['loop'] % $woocommerce_loop['columns'] )
	{
		$classes[] = 'last';
	}


	$product_tag_slug = get_query_var( 'product_tag' );
	$permalink        = $product->get_permalink() . '?ptype=' . $product_tag_slug;
	$store_info = dokan_get_store_info( $product->post->post_author );

	$price_terms = [
		'framed-art'         => 'framed_print',
		'art-print'          => 'art_print',
		'photography'        => 'photo_print',
		'stretched-canvases' => 'canvas',
		'posters'            => 'poster',
	];

	$preview_price = IB_Utils::get_base_price( $product->id, $price_terms[ $product_tag_slug ] );

	//do_action( 'woocommerce_before_shop_loop_item' );
?>


<div class="cell col-sm-4">

	<div class="pull-right like-container">
		<?php get_template_part( 'dokan/btn', 'like' ); ?>
	</div>

	<a href="<?= $permalink ?>" class="has-border archive-<?= $wp_query->query_vars['product_tag'] ?>">
		<?= $product->get_image( 'shop_catalog', [ 'class' => 'img-responsive', ] ) ?>
	</a>


	<div class="prod-meta">
		<a href="<?= $permalink ?>" class="invi-link">&nbsp;</a>

		<div class="info">
			<a href="<?= $permalink ?>"><span class="title"><?= $product->get_title() ?></span></a>
			<a href="<?= dokan_get_store_url( $product->post->post_author ) ?>"><span
					class="author"><?= $store_info['store_name'] ?></span></a>
			<a href="<?= $permalink ?>"><span class="base-price">From <?= $preview_price ?></span></a>
		</div>
	</div>
</div>

