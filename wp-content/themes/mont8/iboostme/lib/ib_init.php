<?php

	/*handles any logic for Seller Class IB_User*/
	$ib_user = new IB_User();


	/*Hide some menus when the seller has no product yet*/
	add_filter( 'dokan_get_dashboard_nav', 'hide_some_seller_nav' );

	function hide_some_seller_nav( $urls )
	{
		global $ib_user;

		if ( $ib_user->has_artwork() )
		{
			return $urls;
		}

		unset( $urls['pricing'] );

		return $urls;
	}


	/**
	 * Activate Customer Account
	 *
	 */
	function activate_account()
	{

		global $wpdb;

		$key = $wpdb->get_row( "SELECT * FROM mo_usermeta WHERE meta_value = '{$_GET[key]}'" );


		/*If key returns null redirect to my account*/
		if ( ! $key )
		{
			wp_safe_redirect( apply_filters( 'woocommerce_registration_redirect', wp_get_referer() ? wp_get_referer() : wc_get_page_permalink( 'myaccount' ) ) );
		}

		/*Determine if customer or seller*/
		if ( $key->meta_key == 'seller_verification_key' )
		{
			wc_add_notice( 'Awesome! You can start selling now!' );
			update_user_meta( $key->user_id, 'dokan_enable_selling', 'yes' );
		}
		else
		{
			wc_add_notice( 'Awesome! Your account is now activated. Enjoy Shopping!' );
			update_user_meta( $key->user_id, 'is_account_verified', 1 );
		}

		if ( ! is_user_logged_in() )
		{
			wc_set_customer_auth_cookie( $key->user_id );
		}

		wp_safe_redirect( apply_filters( 'woocommerce_registration_redirect', wp_get_referer() ? wp_get_referer() : wc_get_page_permalink( 'myaccount' ) ) );
	}

	if ( ( $_GET['action'] == 'activate_customer_account' | $_GET['action'] == 'activate_seller_account' ) && $_GET['key'] )
	{
		add_action( 'wp_loaded', 'activate_account' );
	}