<?php
	/**
	 * Simple product add to cart
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     2.1.0
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	global $product;

	if ( ! $product->is_purchasable() )
	{
		return;
	}

	//	var_dump($_POST);

	$prod_description = $product->post->post_content;
	$is_square = is_square( $product->get_image_id() );

	//	var_dump($is_square);

	$image_data = wp_get_attachment_metadata( $product->get_image_id() );

	$cart = end( WC()->cart->get_cart() );

	$available_artwork_types = get_the_terms( $product->id, 'product_tag' );
	//	$cart_price = number_format( $cart['tm_epo_options_prices'] * get_current_currency( 'rate' ), 2 ) . get_current_currency( 'symbol' );

?>

<script>
	window.last_cart_added = <?=json_encode($cart)?>;
	window.shop_url = '<?=shop_url()?>';
	window.checkout_url = '<?=WC()->cart->get_checkout_url()?>';
	window.image_data = <?=json_encode($image_data)?>;

</script>

<div class="overlay-preloader"></div>

<?php if ( $prod_description ): ?>
	<div itemprop="description" class="product-description collapsed">
		<?php echo apply_filters( 'woocommerce_short_description', get_the_content() ) ?>
	</div>
<?php endif; ?>

<?php
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
?>

<?php if ( $product->is_in_stock() ) : ?>

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" method="post" enctype='multipart/form-data'>


		<?php do_action( 'woocommerce_before_add_to_cart_button' ); ?>


		<!--		<div class="currency-switcher col-md-6"></div>-->


		<?php
			if ( ! $product->is_sold_individually() )
			{
				woocommerce_quantity_input( array(
					'min_value' => apply_filters( 'woocommerce_quantity_input_min', 1, $product ),
					'max_value' => apply_filters( 'woocommerce_quantity_input_max', $product->backorders_allowed() ? '' : $product->get_stock_quantity(), $product )
				) );
			}
		?>

		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->id ); ?>"/>

		<div class="row">
			<div class="col-md-5">
				<button type="submit"
				        class="single_add_to_cart_button button alt btn-block"><?php echo $product->single_add_to_cart_text(); ?></button>
			</div>

			<div class="col-md-7">

				<?= do_shortcode( '[yith_wcwl_add_to_wishlist]' ) ?>

				<div class="favorite-wrap">
					<a href="#addtowishlist" class="heart add_to_wishlist_btn" data-toggle="tooltip"
					   data-placement="top" title="Add artwork to Wishlist"></a>
			        <span class="counter">
			          <a href="#" class="favorite-count favorite-count-864"><?= count_wishlist( $product->id ) ?></a>
			        </span>
				</div>

				<button type="button" id="share-button" class="button social">
					<span class="facebook"><i class="fa fa-facebook"></i></span>
					<span class="twitter"><i class="fa fa-twitter"></i></span>
					<span class="pinterest"><i class="fa fa-pinterest"></i></span>
				</button>


			</div>
		</div>

		<div class="preview-wall-container">
			<a href="#!" class="preview-wall-btn"><i
					class="fa fa-arrows-alt"></i> <?= _e( 'View this piece on a wall', 'dokan' ) ?></a>
		</div>

		<div class="artwork-thumbnail">

			<a href="<?= default_frame_art_big() ?>" data-dir="<?= get_frame_art_dir() ?>" itemprop="image"
			   class="imagesize mo-frame" data-rel="prettyPhoto">
				<img src="<?= default_frame_art_thumb() ?>">
			</a>

			<a href="#" itemprop="image" class="imagesize mo-artwork" data-rel="prettyPhoto">
				<?= woocommerce_get_product_thumbnail( 'thumbnail' ) ?>
			</a>

		</div>


		<?php do_action( 'woocommerce_after_add_to_cart_button' ); ?>
	</form>

	<? //=do_shortcode("[woocs show_flags=1 width='100%']")?>


	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>


	<div class="share-overlay overlay hide">
		<div class="overlay-inner">

			<span class="caption"><?= __( "Hey you, you're awesome. Share and show some love!", 'dokan' ) ?></span>

			<div class="button-wrap">
				<button id="fbclick" class="icon facebook"
				        data-request-path="https://www.facebook.com/sharer/sharer.php?u=<?= the_permalink() ?>"><i
						class="fa fa-facebook"></i></button>
				<button id="twclick" class="icon twitter"
				        data-request-path="https://twitter.com/share?count=vertical&amp;counturl=<?= the_permalink() ?>&amp;via=mont8">
					<i class="fa fa-twitter"></i></button>
				<button id="gplusclick" class="icon google"
				        data-request-path="https://plus.google.com/share?url=<?= the_permalink() ?>"><i
						class="fa fa-google"></i></button>
				<button id="pinclick" class="icon pinterest"
				        data-request-path="//www.pinterest.com/pin/create/button?description=<?= get_the_title() ?>&amp;url=<?= the_permalink() ?>">
					<i class="fa fa-pinterest"></i></button>
			</div>

		</div>
	</div>

	<?php get_template_part( 'iboostme/single-product/preview-on-the-wall' ); ?>


	<?php if ( $is_square ): ?>
		<script>
			var is_square = true;
			jQuery(document).ready(function ($) {

				$("input.square-artwork").prop('checked', true);
				$("input[value=Poster_4]").parent().hide();
				setTimeout(function () {
					$(".staging-products > li:nth-child(5)").hide();
				}, 2000);
			});
		</script>
	<?php endif; ?>


	<?php if ( isset( $_POST['tmcp_checkbox_24_0'] ) ): ?>
		<script>
			jQuery(document).ready(function ($) {

				setTimeout(function () {
					$("input.frame-this-print").click();

				}, 3000);

				setTimeout(function () {
					$("div.select-image-size:not([style='display: none;'])").find("select").change();
					$("div.select-image-size-div:not([style='display: none;'])").find("select").change();

				}, 4000);


			});
		</script>
	<?php endif; ?>


	<?php if ( $available_artwork_types ): ?>

		<script>
			jQuery(document).ready(function ($) {

				$(".artwork-style-ul > li").hide();

				<?php
					$ref = [
						'art-print' => 2,
						'photography' => 3,
						'stretched-canvases' => 4,
						'posters' => 5,

					];

					foreach($available_artwork_types as $type):

						if(!$ref[$type->slug]){
							continue;
						}
				?>

				$(".artwork-style-ul > li:nth-child(<?=$ref[$type->slug]?>)").show();

				<?php endforeach; ?>

			});
		</script>

	<?php endif; ?>


<?php endif; ?>
