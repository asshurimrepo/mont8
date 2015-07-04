<?php
	GlobalPricing::listens();
?>

<p>
	<a title="Pricing your work" href="#!" target="_blank">Pricing your work</a> is entirely up to you and can be done on a per-image basis or in bulk here. However it goes without saying that lower prices generate more sales. Finding a balance between an affordable cost for the buyer and and a fair profit for you is key. We have suggested an optimal rate of 30% across each product.
	<p>Markup percentage must be between <strong>0-100%</strong></p>
</p>

<form id="pricing-form" class="pricing-form" method="post">
	<?php iboost_include('iboostme/dashboard/product-pricing-table'); ?>
		
	<div style="text-align:right;">
    	<button type="submit" name="update_pricing" class="dokan-btn dokan-btn-theme dokan-btn-md"><i class="fa fa-check"></i> <?php esc_attr_e( 'Save Product Markup', 'dokan' ); ?></button>
	</div>
	
</form>



