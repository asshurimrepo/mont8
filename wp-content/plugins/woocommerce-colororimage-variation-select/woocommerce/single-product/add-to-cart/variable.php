<?php

	/**
	 * variable template
	 * Originally Modified from Woocommerce Core
	 * @author        WooThemes
	 * @package    WooCommerce/templates/single-product/add-to-cart/variable.php
	 * @version     2.1.6
	 */


	global $woocommerce, $product, $post;

	$woo_version = wcva_get_woo_version_number();

	$_coloredvariables = get_post_meta( $post->ID, '_coloredvariables', true );


?>

<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>


	<script type="text/javascript">

		var product_variations_<?php echo $post->ID; ?> = <?php echo json_encode( $available_variations ) ?>;

	</script>


	<form class="variations_form cart" method="post" enctype='multipart/form-data'
	      data-product_id="<?php echo $post->ID; ?>"
	      data-product_variations="<?php echo esc_attr( json_encode( $available_variations ) ) ?>">

		<?php if ( ! empty( $available_variations ) ) : ?>


			<table class="variations" cellspacing="0">

				<tbody>

				<?php $loop = 0;
					foreach ( $attributes as $name => $options ) : $loop ++;


						if ( isset( $_coloredvariables[ $name ]['display_type'] ) )
						{

							$attribute_display_type = $_coloredvariables[ $name ]['display_type'];

						}


						$taxonomies = array( $name );

						$args = array(

							'hide_empty' => 0

						);

						$newvalues = get_terms( $taxonomies, $args );


						if ( isset( $_coloredvariables[ $name ]['label'] ) )
						{

							$labeltext = $_coloredvariables[ $name ]['label'];

						}
						else
						{

							if ( $woo_version < 2.1 )
							{

								$labeltext = $woocommerce->attribute_label( $name );

							}
							else
							{

								$labeltext = wc_attribute_label( $name );

							}

						}


						?>

						<?php if ( $labeltext == 'Product' )
						{
						}
						else
						{ ?>
							<tr>

							<td class="label"><label
									for="<?php echo sanitize_title( $name ); ?>"><?php if ( isset( $labeltext ) && ( $labeltext != '' ) )
									{
										echo $labeltext;
									}
									else
									{
										echo wc_attribute_label( $name );
									} ?></label>
							</td></tr><?php } ?>
						<tr>

						<td class="value"> <?php


								if ( is_array( $options ) )
								{


									if ( isset( $_REQUEST[ 'attribute_' . sanitize_title( $name ) ] ) )
									{

										$selected_value = $_REQUEST[ 'attribute_' . sanitize_title( $name ) ];

									}
									elseif ( isset( $selected_attributes[ sanitize_title( $name ) ] ) )
									{

										$selected_value = $selected_attributes[ sanitize_title( $name ) ];

									}
									else
									{

										$selected_value = '';

									}

								}


								$fields = new wcva_swatch_form_fields();


								if ( isset( $attribute_display_type ) && ( $attribute_display_type == "colororimage" ) )
								{ ?>


									<div class="wcvaswatch">

										<?php $fields->wcva_load_colored_select( $name, $options, $_coloredvariables, $newvalues, $selected_value ); ?>

									</div>

									<a id="btnModal" class="button button_block button_small button_examples"
									   href="#modal-products" data-ga-track-click="true" data-ga-category="Art"
									   data-ga-action="Clicked See Product Examples Link">See product examples</a>


									<?php


									if ( sizeof( $attributes ) == $loop )

									{
										echo '<br /><a class="reset_variations" style="display:none" href="#reset">' . __( 'Clear selection', 'wcva' ) . '</a>';
									}


								}
								elseif ( isset( $attribute_display_type ) && ( $attribute_display_type == "radio" ) )
								{

									$fields->wcva_load_radio_select( $name, $options, $selected_value );


									if ( sizeof( $attributes ) == $loop )

									{
										echo '<br /><a class="reset_variations" style="display:none" href="#reset">' . __( 'Clear selection', 'wcva' ) . '</a>';
									}


								}
								else
								{ ?>

									<div class="cartdd">

										<?php $fields->wcva_load_dropdown_select( $name, $options, $selected_value ); ?>
									</div>


									<?php if ( sizeof( $attributes ) == $loop )

								{
									echo '<br /><span style="display:none"><a class="reset_variations" href="#reset">' . __( 'Clear selection', 'wcva' ) . '</a></span>';
								}


								}


							?></td>

						</tr>



					<?php endforeach; ?>

				</tbody>

			</table>

			<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>

			<!--Short Description-->
			<section class="short-description">
				<?php echo apply_filters( 'woocommerce_short_description', $post->post_content ) ?>
			</section>

			<!--Add to Cart Button-->
			<div class="row">
				<div class="col-md-5 single_variation_wrap" style="display: none">

					<?php do_action( 'woocommerce_before_single_variation' ); ?>

					<div class="single_variation"></div>


					<div class="variations_button">

						<?php woocommerce_quantity_input(); ?>

						<button type="submit" class="single_add_to_cart_button button alt">
							<i class="fa fa-shopping-cart"></i>

							<?php


								if ( $woo_version < 2.1 )
								{

									echo apply_filters( 'single_add_to_cart_text', __( 'Add to cart', 'woocommerce' ), $product->product_type );


								}
								else
								{


									echo $product->single_add_to_cart_text();

								}


							?>

						</button>

					</div>


					<input type="hidden" name="add-to-cart" value="<?php echo $product->id; ?>"/>

					<input type="hidden" name="product_id" value="<?php echo esc_attr( $post->ID ); ?>"/>

					<input type="hidden" name="variation_id" value=""/>


					<?php do_action( 'woocommerce_after_single_variation' ); ?>


				</div>
				<div class="col-md-4">
					<?=do_shortcode('[yith_wcwl_add_to_wishlist]')?>
				</div>
			</div>


			<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>


		<?php else : ?>


			<p class="stock out-of-stock"><?php _e( 'This product is currently out of stock and unavailable.', 'wcva' ); ?></p>


		<?php endif; ?>


	</form>

	<script>


		jQuery(document).ready(function () {

			jQuery('div[data-uniqid="550dd080498de8.59424284"]').hide();

			jQuery('.swatchinput').click(function () {

				//Highlight selected Swatch

				jQuery('.swatchinput .wcvaswatchlabel').removeClass('highlightit');

				jQuery('.swatchinput .belowtext').removeClass('highlightit');

				jQuery(this).find('.wcvaswatchlabel').addClass('highlightit');

				jQuery(this).find('.belowtext').addClass('highlightit');


				//Play with frames


				if (jQuery(this).find('input').attr('value') == "fine-art") {

					jQuery('.woocommerce-main-image').attr('class', 'imagesize woocommerce-main-image zoom ArtPrint ');

					jQuery('#tm-extra-product-options-fields').fadeOut("fast");


				} else if (jQuery(this).find('input').attr('value') == "framed-art") {

					jQuery('div[data-uniqid="5519d354bdafd6.65024879"]').fadeIn("fast");

					jQuery('div[data-uniqid="5519c3c7f00bd4.16908439"]').fadeIn("fast");

					jQuery('div[data-uniqid="550dd080498de8.59424284"]').fadeOut("fast");

					jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom framed-photo-prints Brown size-14-8-x-21-a5');

					jQuery('#tmcp_select_1').val('Flat_1');

					jQuery('#tmcp_select_2').val('Brown_0');

					jQuery('#tmcp_select_3').val('Off-White_0');

					jQuery('#tm-extra-product-options-fields').fadeIn("fast");


				} else if (jQuery(this).find('input').attr('value') == "stretched-canvases") {

					jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom canvas no-frame');

					jQuery('div[data-uniqid="5519d354bdafd6.65024879"]').fadeOut("fast");

					jQuery('div[data-uniqid="5519c3c7f00bd4.16908439"]').fadeOut("fast");

					jQuery('div[data-uniqid="550dd080498de8.59424284"]').fadeIn("fast");


				} else if (jQuery(this).find('input').attr('value') == "photography") {

					jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom photography no-frame');

					jQuery('div[data-uniqid="5519d354bdafd6.65024879"]').fadeOut("fast");

					jQuery('div[data-uniqid="5519c3c7f00bd4.16908439"]').fadeOut("fast");

					jQuery('div[data-uniqid="550dd080498de8.59424284"]').fadeIn("fast");


				} else if (jQuery(this).find('input').attr('value') == "posters") {

					jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom ArtPrint no-frame');

					jQuery('div[data-uniqid="5519d354bdafd6.65024879"]').fadeOut("fast");

					jQuery('div[data-uniqid="5519c3c7f00bd4.16908439"]').fadeOut("fast");

					jQuery('div[data-uniqid="550dd080498de8.59424284"]').fadeIn("fast");


				}

			});


			jQuery("#tmcp_select_1").change(function () {

				jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom framed-photo-prints Brown size-14-8-x-21-a5');

				jQuery('.woocommerce-main-image').addClass(jQuery(this).val());

				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_2').val());

				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_3').val());

			});


			jQuery("#tmcp_select_2").change(function () {

				jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom framed-photo-prints Brown size-14-8-x-21-a5');

				jQuery('.woocommerce-main-image').addClass(jQuery(this).val());

				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_1').val());

				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_3').val());

			});

			jQuery("#tmcp_select_3").change(function () {

				jQuery('.woocommerce-main-image').attr('class', 'woocommerce-main-image zoom framed-photo-prints Brown size-14-8-x-21-a5');

				jQuery('.woocommerce-main-image').addClass(jQuery(this).val());

				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_1').val());

				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_2').val());

			});


			jQuery("#size").change(function () {
				jQuery('.woocommerce-main-image').attr('class', 'imagesize woocommerce-main-image framed-photo-prints zoom');
				jQuery('.woocommerce-main-image').addClass(jQuery(this).val());
				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_1').val());
				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_2').val());
				jQuery('.woocommerce-main-image').addClass(jQuery('#tmcp_select_3').val());
			});


		});


	</script>


<?php do_action( 'woocommerce_after_add_to_cart_form' );

     

	 

	 