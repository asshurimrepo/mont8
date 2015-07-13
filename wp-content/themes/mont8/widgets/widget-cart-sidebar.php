<div class="cart-overlay"></div>

<div class="cart-sidebar animated" style="display: none;">


	<div class="btn-cart-sidebar cart-sidebar-close">X</div>
	<span class="cart-sidebar-detail cart-sidebar-item-number">Items <span class="badge"><?=WC()->cart->cart_contents_count?></span></span>

	<?php if(!is_user_logged_in()): ?>
		<a href="<?=get_my_account_url()?>"><span class="cart-sidebar-detail cart-sidebar-sign-in"><i class="fa fa-sign-in"></i> Sign In</span></a>
	<?php endif; ?>

	<div class="clearfix"></div>
	<div class="divider-line"></div>

	<?php foreach ( WC()->cart->get_cart() as $cart_item_key => $cart ): $_product = $cart['data']->post; ?>
		<?php $prod_item = 	apply_filters( 'woocommerce_cart_item_product', $cart['data'], $cart, $cart_item_key ); ?>

		<div class="cart-sidebar-item">
			<div class="cart-sidebar-image-box">
				<?=$prod_item->get_image('thumbnail', ['class'=>'cart-sidebar-image img-responsive', 'style'=>'width:75px;'])?>
<!--				<img src="http://placehold.it/75x100/" alt="" class="cart-sidebar-image img-responsive"/>-->
			</div>
			<h4 class="cart-sidebar-title"><?=$_product->post_title?></h4>
			<span class="cart-sidebar-detail">Price:
				<?php
					echo apply_filters( 'woocommerce_cart_item_price', WC()->cart->get_product_price( $prod_item ), $cart, $cart_item_key );
				?>
			</span>
			<span class="cart-sidebar-detail">Quantity: <?=$cart['quantity']?></span>
			<a href="<?=WC()->cart->get_remove_url($cart_item_key)?>" class="cart-sidebar-btn-remove">Remove <i class="fa fa-times-circle-o"></i> </a>
		</div>

		<div class="divider-space"></div>


	<?php endforeach; ?>


	<div class="divider-line"></div>
	<span class="cart-sidebar-detail cart-sidebar-subtotal">Subtotal: <span
			class="cart-sidebar-subtotal-number"><?=WC()->cart->get_cart_total()?></span></span>
	<a href="<?=WC()->cart->get_checkout_url()?>" class="cart-sidebar-btn-checkout btn btn-primary btn-lg btn-block">Proceed to Checkout</a>
	<a href="<?=WC()->cart->get_cart_url()?>" class="cart-sidebar-btn-checkout btn btn-primary btn-lg btn-block hide">View Cart</a>
</div>