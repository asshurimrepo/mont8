<?php
	/**
	 * Edit account form
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     2.2.7
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

	//	User_Actions::listens();
	$store_info = get_user_meta( $user->ID, 'dokan_profile_settings', true );
	//	var_dump($store_info);

?>

<?php wc_print_notices(); ?>

<form action="" method="post">

	<?php do_action( 'woocommerce_edit_account_form_start' ); ?>

	<p class="form-row form-row-first">
		<label for="account_first_name"><?php _e( 'First name', 'woocommerce' ); ?> <span
				class="required">*</span></label>
		<input type="text" class="input-text" name="account_first_name" id="account_first_name"
		       value="<?php echo esc_attr( $user->first_name ); ?>"/>
	</p>

	<p class="form-row form-row-last">
		<label for="account_last_name"><?php _e( 'Last name', 'woocommerce' ); ?> <span
				class="required">*</span></label>
		<input type="text" class="input-text" name="account_last_name" id="account_last_name"
		       value="<?php echo esc_attr( $user->last_name ); ?>"/>
	</p>

	<div class="clear"></div>

	<p class="form-row form-row-first">
		<label for="account_email"><?php _e( 'Email address', 'woocommerce' ); ?> <span
				class="required">*</span></label>
		<input type="email" class="input-text" name="account_email" id="account_email"
		       value="<?php echo esc_attr( $user->user_email ); ?>"/>
	</p>

	<?php if ( dokan_is_user_seller( $user->ID ) ): ?>
		<p class="form-row form-row-last">
			<label for="account_last_name"><?php _e( 'Store Name', 'dokan' ); ?> <span
					class="required">*</span></label>
			<input type="text" class="input-text" name="dokan_store_name" id="dokan_store_name"
			       value="<?php echo esc_attr( $store_info['store_name'] ); ?>"/>
			<span class="text-muted"><em><?= dokan_get_store_url( $user->ID ) ?></em></span>
		</p>
	<?php endif; ?>

	<div class="clear"></div>

	<?= do_shortcode( '[h_space]' ) ?>

	<fieldset>
		<legend><?php _e( 'Password Change', 'woocommerce' ); ?></legend>

		<p class="form-row form-row-wide">
			<label
				for="password_current"><?php _e( 'Current Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_current" id="password_current"/>
		</p>

		<p class="form-row form-row-wide">
			<label
				for="password_1"><?php _e( 'New Password (leave blank to leave unchanged)', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_1" id="password_1"/>
		</p>

		<p class="form-row form-row-wide">
			<label for="password_2"><?php _e( 'Confirm New Password', 'woocommerce' ); ?></label>
			<input type="password" class="input-text" name="password_2" id="password_2"/>
		</p>
	</fieldset>
	<div class="clear"></div>

	<?php do_action( 'woocommerce_edit_account_form' ); ?>

	<p>
		<?php wp_nonce_field( 'save_account_details' ); ?>
		<input type="submit" class="button" name="save_account_details"
		       value="<?php _e( 'Save changes', 'woocommerce' ); ?>"/>
		<input type="hidden" name="action" value="save_account_details"/>
	</p>

	<?php do_action( 'woocommerce_edit_account_form_end' ); ?>

</form>
