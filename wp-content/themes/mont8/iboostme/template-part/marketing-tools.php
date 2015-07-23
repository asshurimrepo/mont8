<?php
	$dokan_template_settings = Dokan_Template_Settings::init();
	$validate                = $dokan_template_settings->profile_validate();

	if ( $validate !== false && !is_wp_error( $validate ) ) {
		$dokan_template_settings->insert_settings_info();
	}

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

<div class="col-md-9">

	<h2>Social Profiles</h2>

	<article class="dokan-settings-area">
		<!-- .dokan-dashboard-header -->

		<div class="dokan-page-help">
			<?php _e( 'Link all of your favourite social profiles to drive your fans to your gallery! Tell us if these social media plug ins are enough.', 'dokan' ); ?>
		</div>

		<?php if ( is_wp_error( $validate ) ) {
			$messages = $validate->get_error_messages();

			foreach( $messages as $message ) {
				?>
				<div class="dokan-alert dokan-alert-danger" style="width: 40%; margin-left: 25%;">
					<button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
					<strong><?php echo $message; ?></strong>
				</div>

				<?php
			}
		} ?>

		<?php //$dokan_template_settings->setting_field($validate); ?>

		<!--settings updated content-->
		<?php
			global $current_user;

			if ( isset( $_GET['message'] ) ) {
				?>
				<div class="dokan-alert dokan-alert-success">
					<button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
					<strong><?php _e( 'Your profile has been updated successfully!', 'dokan' ); ?></strong>
				</div>
				<?php
			}

			$profile_info  = dokan_get_store_info( $current_user->ID );
			$social_fields = dokan_get_social_profile_fields();
		?>

		<div class="dokan-ajax-response"></div>

		<?php
			/**
			 * @since 2.2.2 Insert action before social settings form
			 */
			do_action( 'dokan_profile_settings_before_form', $current_user, $profile_info ); ?>

		<form method="post" id="profile-form"  action="" class="dokan-form-horizontal"><?php ///settings-form ?>

			<?php wp_nonce_field( 'dokan_profile_settings_nonce' ); ?>

			<?php foreach( $social_fields as $key => $field ) { ?>
				<div class="dokan-form-group">
					<label class="dokan-w3 dokan-control-label"><?php echo $field['title']; ?></label>

					<div class="dokan-w5">
						<div class="dokan-input-group dokan-form-group">
							<span class="dokan-input-group-addon"><i class="icon-<?php echo isset( $field['icon'] ) ? $field['icon'] : ''; ?>"></i></span>
							<input id="settings[social][<?php echo $key; ?>]" value="<?php echo isset( $profile_info['social'][$key] ) ? esc_url( $profile_info['social'][$key] ) : ''; ?>" name="settings[social][<?php echo $key; ?>]" class="dokan-form-control" placeholder="http://" type="url">
						</div>
					</div>
				</div>
			<?php } ?>

			<?php
				/**
				 * @since 2.2.2 Insert action on bottom social settings form
				 */
				do_action( 'dokan_profile_settings_form_bottom', $current_user, $profile_info ); ?>

			<div class="dokan-form-group">
				<div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
					<input type="submit" name="dokan_update_profile_settings" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Save', 'dokan' ); ?>">
				</div>
			</div>

		</form>

		<?php
			/**
			 * @since 2.2.2 Insert action after social settings form
			 */
			do_action( 'dokan_profile_settings_after_form', $current_user, $profile_info ); ?>
		<!--settings updated content end-->

	</article>


</div>