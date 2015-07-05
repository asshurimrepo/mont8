<?php
	$store_url = dokan_get_store_url( get_current_user_id() );
?>

<script src="<?=get_stylesheet_directory_uri()?>/iboostme/js/marketing.js"></script>

<div class="col-md-12">
	<div class="row">
		<div class="col-md-7">

			<h2>Share your Gallery</h2>

			<?=do_shortcode('[h_space]')?>

			<p><h4>You gallery URL is:</h4>
				<input type="text" class="form-control" value="<?=$store_url?>" readonly="readonly"></p>
		</div>
	</div>


	<?=do_shortcode('[h_space size=20]')?>

	<p>Spread the word about your gallery with fans, friends and family.</p>

	<div class="button-group social-info row" data-ref="Marketing" data-social-share-parent="true"
	     data-social-share-title="<?=urlencode('Check out my Mont8 art gallery!')?>"
	     data-social-share-image="<?=urlencode('http://mont8.com/staging/wp-content/uploads/2015/06/mont8-big.jpg')?>"
	     data-social-share-link="<?=urlencode($store_url)?>">

		<a href="#" class="btn azm-social azm-btn azm-facebook"><i class="fa fa-facebook"></i> Share on <strong>Facebook</strong></a>
		<a href="#" class="btn azm-social azm-btn azm-twitter"><i class="fa fa-twitter"></i> Share on <strong>Twitter</strong></a>
		<a href="#" class="btn azm-social azm-btn azm-pinterest"><i class="fa fa-pinterest"></i> Share on <strong>Pinterest</strong></a>
		<a href="#" class="btn azm-social azm-btn azm-google-plus"><i class="fa fa-google-plus"></i> Share on <strong>Google+</strong></a>


	</div>
</div>