<?php
	/**
	 * Single Product Image
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     2.0.14
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	global $post, $woocommerce, $product;
	Share::setData( $product );

?>
<div class="images">
	<div class="image-grey">

		<?php
			if ( has_post_thumbnail() )
			{

				$image_title   = esc_attr( get_the_title( get_post_thumbnail_id() ) );
				$image_caption = get_post( get_post_thumbnail_id() )->post_excerpt;
//			$image_link  	= wp_get_attachment_url( get_post_thumbnail_id() );
				$image_link = wp_get_attachment_image_src( get_post_thumbnail_id(), 'shop_single' );
				$image      = get_the_post_thumbnail( $post->ID, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array(
					'title' => $image_title,
					'alt'   => $image_title
				) );

				$attachment_count = count( $product->get_gallery_attachment_ids() );

				if ( $attachment_count > 0 )
				{
					$gallery = '[product-gallery]';
				}
				else
				{
					$gallery = '';
				}

				$like_btn = '';

				?>

				<a href="#!" itemprop="image"
				   class="imagesize woocommerce-main-image zoom framed-photo-prints Brown size-14-8-x-21-a5"
				   title="<?= $image_caption ?>" data-rel="prettyPhoto' . $gallery . '">
					<div class="pull-right like-container">
						<?php get_template_part( 'dokan/btn', 'like' ); ?>
					</div>
					<?= $image ?>
				</a>

				<?php

//				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<a href="%s" itemprop="image" class="imagesize woocommerce-main-image zoom framed-photo-prints Brown size-14-8-x-21-a5" title="%s" data-rel="prettyPhoto' . $gallery . '">%s</a>', $like_btn.$image_link[0], $image_caption, $image ), $post->ID );

			}
			else
			{

				echo apply_filters( 'woocommerce_single_product_image_html', sprintf( '<img src="%s" alt="%s" />', wc_placeholder_img_src(), __( 'Placeholder', 'woocommerce' ) ), $post->ID );

			}
		?>
	</div>

	<?php do_action( 'woocommerce_product_thumbnails' ); ?>

</div>