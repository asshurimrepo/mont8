<?php
	GlobalPricing::listens();
?>
<form id="pricing-form" class="pricing-form" method="post">
	<?php iboost_include('iboostme/dashboard/product-pricing-table'); ?>
		
	<div style="text-align:right;">
    	<button type="submit" name="update_pricing" class="dokan-btn dokan-btn-theme dokan-btn-md"><i class="fa fa-check"></i> <?php esc_attr_e( 'Save Product Markup', 'dokan' ); ?></button>
	</div>
	
</form>



