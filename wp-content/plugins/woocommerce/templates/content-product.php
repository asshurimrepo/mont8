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
<li <?php post_class( $classes ); ?>>




		<?php do_action( 'woocommerce_before_shop_loop_item' ); ?>
		<a href="<?php the_permalink(); ?>" class="archive-<?=$wp_query->query_vars['product_tag']?>">
			<div class="artworks">
				<?php

					do_action( 'woocommerce_before_shop_loop_item_title' );
				?>
			</div>


			<?php

				do_action( 'woocommerce_after_shop_loop_item_title' );
			?>

		</a>

		<h3 class="shop_heading_text"><?php the_title(); ?> <small><?=$base_price?></small></h3>



	<?php

		/**
		 * woocommerce_after_shop_loop_item hook
		 *
		 * @hooked woocommerce_template_loop_add_to_cart - 10
		 */
//		do_action( 'woocommerce_after_shop_loop_item' );

	?>

</li>
