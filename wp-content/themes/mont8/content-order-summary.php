<?php
	global $post, $wp_query;
?>

<?php if ( ! isset( $_GET['key'] ) ): ?>

	<h1 class="order-title" style="font-weight: 300"><?= __( 'Order Summary', 'dokan' ) ?></h1>


	<div class="order-summary">
		<ul class="steps list-unstyled">
			<li class="active"><a href="#!" data-step="1"><span class="number">1</span> Order Summary</a></li>
			<li><a href="#!" data-step="2"><span class="number">2</span> Shipping Information</a></li>
			<li><a href="#!" data-step="3"><span class="number">3</span> Checkout</a></li>
		</ul>

		<section class="order-steps-container">

			<?= do_shortcode( '[woocommerce_checkout]' ) ?>


			<div class="step-item active" id="step1">
				<?= do_shortcode( '[woocommerce_cart]' ) ?>
			</div>

		</section>

		<div class="pull-right">
			<b>Any questions? <a href="<?= get_permalink_by_slug( 'contact-us' ) ?>">Contact us</a></b>
		</div>

	</div>

<?php else: ?>
	<section class="order-steps-container">
		<?= do_shortcode( '[woocommerce_checkout]' ) ?>
	</section>


<?php endif; ?>







