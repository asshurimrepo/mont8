<?php
	$dokan_template_settings = Dokan_Template_Settings::init();
	$validate                = $dokan_template_settings->validate();

	if ( $validate !== false && ! is_wp_error( $validate ) )
	{
		$dokan_template_settings->insert_settings_info();
	}
?>
<div class="dokan-dashboard-wrap">
	<?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => 'settings/payment' ) ); ?>

	<div class="dokan-dashboard-content dokan-settings-content">
		<article class="dokan-settings-area">
			<header class="dokan-dashboard-header">
				<h1 class="nice">
					<?php _e( 'Payment Settings', 'dokan' ); ?>
				</h1>
			</header>

			<!-- .dokan-dashboard-header -->
			<h2><?php _e( 'When do I get paid', 'dokan' ); ?></h2>

			<div>
				You can claim your money from your available balance anytime during the month. All claimed payments that
				satisfy the threshold for your payment method will be paid to our beloved artists on or before the 15th
				day of the following month.<br/><br/>

				At that time, we pay to you any shipped sales made up until the end of the previous month, given that
				you have made over the threshold for your chosen payment type.
				Let’s say: <br/><br/>
				<ul style="margin: 0; padding: 0">
					<li>• You made over the threshold for a PayPal payment and your sales were shipped by the end of
						November, you
						will get paid on or before 15th December.
					</li>
					<li>• A sale was made before the end of the previous month but has not yet shipped; this will be
						paid on the
						next eligible month, on which the threshold has been reached.
						In short, if an order has been placed but not yet shipped, it is not yet payable. If an order is
						cancelled,
						for any reason before it ships, it will not be payable.
					</li>
				</ul>

			</div>
			<hr>

			<?php dokan_get_template_part( 'threshold', 'table' ); ?>

			<hr>

			<div class="dokan-page-help">
				<?php _e( 'These are the withdraw methods available for you. Please update your payment informations below to submit withdraw requests and get your store payments seamlessly.', 'dokan' ); ?>
			</div>

			<?php if ( is_wp_error( $validate ) )
			{
				$messages = $validate->get_error_messages();

				foreach ( $messages as $message )
				{
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

				if ( isset( $_GET['message'] ) )
				{
					?>
					<div class="dokan-alert dokan-alert-success">
						<button type="button" class="dokan-close" data-dismiss="alert">&times;</button>
						<strong><?php _e( 'Your profile has been updated successfully!', 'dokan' ); ?></strong>
					</div>
					<?php
				}

				$profile_info = dokan_get_store_info( $current_user->ID );


				//				var_dump($profile_info);

				if ( is_wp_error( $validate ) )
				{
				}
			?>

			<div class="dokan-ajax-response"></div>

			<?php
				/**
				 * @since 2.2.2 Insert action before payment settings form
				 */
				do_action( 'dokan_payment_settings_before_form', $current_user, $profile_info ); ?>

			<form method="post" id="payment-form" action="" class="dokan-form-horizontal">

				<?php
					wp_nonce_field( 'dokan_payment_settings_nonce' );
					$methods = dokan_withdraw_get_active_methods(); //var_dump($methods);
					$primary = dokan_withdraw_get_method( $profile_info['payment']['primary'] );
				?>

				<?php if ( $primary ): ?>
					<p style="text-align: left">
						<b>Your primary payment gateway: </b><?= $primary['title'] ?>
					</p>
				<?php endif; ?>


				<!-- Nav tabs -->
				<ul class="nav nav-tabs" role="tablist">
					<?php foreach ( $methods as $i => $method_key ): $method = dokan_withdraw_get_method( $method_key ); ?>
						<li role="presentation" class="<?= $i != 'paypal' ?: 'active' ?>">
							<a href="#<?= $method_key ?>"
							   aria-controls="<?= $method_key ?>"
							   role="tab"
							   data-toggle="tab"><?= $method['title'] ?></a>
						</li>
					<?php endforeach; ?>
				</ul>

				<!-- Tab panes -->
				<div class="tab-content">
					<?php foreach ( $methods as $i => $method_key )
					{
						$method = dokan_withdraw_get_method( $method_key );
						?>
						<div role="tabpanel" class="tab-pane <?= $i != 'paypal' ?: 'active' ?>" id="<?= $method_key ?>">

							<fieldset classs="payment-field-<?php echo $method_key; ?>" style="padding: 50px 0;">
								<div class="dokan-form-group">
									<label class="dokan-w3 dokan-control-label"
									       for="dokan_setting"><?php echo $method['title'] ?></label>

									<div class="dokan-w6">
										<?php if ( is_callable( $method['callback'] ) )
										{
											call_user_func( $method['callback'], $profile_info );
										} ?>


										<div class="dokan-form-group">
											<div class="dokan-w8">
												<label class="dokan-control-label">
													Set as primary
												</label>
												<input type="checkbox" class="switcher" name="settings[primary]"
												       value="<?= $method_key ?>" <?= $profile_info['payment']['primary'] == $method_key ? 'checked' : '' ?> >
											</div>
										</div>

									</div>
									<!-- .dokan-w6 -->
								</div>
							</fieldset>

						</div>
					<?php } ?>
				</div>

				<?php
					/**
					 * @since 2.2.2 Insert action on botton of payment settings form
					 */
					do_action( 'dokan_payment_settings_form_bottom', $current_user, $profile_info ); ?>

				<div class="dokan-form-group">

					<div class="dokan-w4 ajax_prev dokan-text-left" style="margin-left:24%;">
						<input type="submit" name="dokan_update_payment_settings"
						       class="dokan-btn dokan-btn-danger dokan-btn-theme"
						       value="<?php esc_attr_e( 'Update Settings', 'dokan' ); ?>">
					</div>
				</div>

			</form>

			<?php
				/**
				 * @since 2.2.2 Insert action after social settings form
				 */
				do_action( 'dokan_payment_settings_after_form', $current_user, $profile_info ); ?>

			<!--settings updated content ends-->
		</article>
	</div>
	<!-- .dokan-dashboard-content -->
</div><!-- .dokan-dashboard-wrap -->

<script>
	jQuery(document).ready(function ($) {

		$("input.switcher").bootstrapSwitch({
			onText: 'Yes',
			offText: 'No',
			onSwitchChange: function (evt, state) {

				$("input.switcher").not(evt.target).each(function () {
					$(this).bootstrapSwitch('state', false, true);
				});


			}
		});

	});
</script>