<?php

	/**
	 * Do not auto login the user when doing registration process
	 *
	 * @return bool
	 */
	function woocommerce_registration_auth_new_customer_to_false()
	{
		return false;
	}

	add_filter( 'woocommerce_registration_auth_new_customer', 'woocommerce_registration_auth_new_customer_to_false' );


	/**
	 * @param $user_id
	 *
	 * @return array
	 */
	function add_email_verification_data( $user_id )
	{
		global $ib_user;

		$_SESSION['show_verification_notice'] = true;

		update_user_meta( $user_id, 'is_account_verified', false );
		update_user_meta( $user_id, 'account_verification_key', IB_Utils::generate_hash() );

		$ib_user->send_customer_activation_email( $user_id );

	}

	add_filter( 'user_register', 'add_email_verification_data' );


	/**
	 * Validate User Log in
	 *
	 * @param $user
	 *
	 * @param $username
	 * @param $password
	 *
	 * @return WP_Error
	 */
	function validate_user_login( $user, $username, $password )
	{

		if ( $user instanceof WP_Error )
		{
			return $user;
		}

		if ( in_array( 'customer', $user->roles ) )
		{
			$is_verified = get_user_meta( $user->ID, 'is_account_verified', true );

			if ( $is_verified )
			{
				return $user;
			}

			return new WP_Error( 'broke', __( "It seems your account is not yet activated. Please follow the instructions in the email to activate your account.", "dokan" ) );
		}

		return $user;
	}

	add_filter( 'authenticate', 'validate_user_login', 30, 3 );


	/*
	 * Show Notices after WP is Loaded
	 * */
	function show_notices()
	{
		if ( $_SESSION['show_verification_notice'] )
		{
			wc_add_notice( 'A confirmation link has been sent to your email address. Please follow the instructions in the email to activate your account.' );
			$_SESSION['show_verification_notice'] = false;
		}


		if ( $_SESSION['send_seller_verification_email'] )
		{
			( new IB_User )->send_seller_activation_email( get_current_user_id() );
			$_SESSION['send_seller_verification_email'] = false;
		}
	}

	add_action( 'wp_loaded', 'show_notices' );


