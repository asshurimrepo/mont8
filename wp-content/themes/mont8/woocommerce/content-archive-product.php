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

	$base_price = IB_Utils::get_base_price($product->id);


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
?>


<?php //do_action( 'woocommerce_before_shop_loop_item' ); ?>


<?php $author = get_userdata( $product->post->post_author ); ?>
<?php $preview_price = IB_Utils::get_base_price( $product->id ); ?>

<div class="cell col-sm-4">

	<a href="<?= $product->get_permalink() ?>" class="has-border archive-<?=$wp_query->query_vars['product_tag']?>">
		<?= $product->get_image( 'shop_catalog', [ 'class' => 'img-responsive', ] ) ?>
	</a>


	<div class="prod-meta">
		<div class="hide"><?=do_shortcode("[yith_wcwl_add_to_wishlist product_id={$product->id}]")?></div>
		<button onclick="jQuery('[data-product-id=<?=$product->id?>]').get(0).click();" class="wishlist btn btn-default" data-toggle="tooltip" title="Like this Artwork"><i class="fa fa-heart"></i></button>
		<a href="<?= $product->get_permalink() ?>" class="invi-link">&nbsp;</a>
		<div class="info">
			<a href="<?= $product->get_permalink() ?>"><span class="title"><?= $product->get_title() ?></span></a>
			<a href="<?= dokan_get_store_url($author->ID) ?>"><span class="author"><?= $author->display_name ?></span></a>
			<a href="<?= $product->get_permalink() ?>"><span class="base-price">From <?= $preview_price ?></span></a>
		</div>
	</div>
</div>

