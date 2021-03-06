<?php

	//Validate Edit Account
	add_action( 'user_profile_update_errors', 'validate_store_info_upon_saving', 10, 1 );

	/**
	 * @param $args
	 */
	function validate_store_info_upon_saving( $args )
	{

		global $current_user;

		$dokan_template_settings = Dokan_Template_Settings::init();
		$dokan_template_settings->insert_settings_info();


		/*
		 * If store name is available validate
		 * */
		if ( isset( $_POST['dokan_store_name'] ) )
		{
			if ( strlen( $_POST['dokan_store_name'] ) < 1 )
			{
				$args->add( 'error', __( 'Store Name is required!', 'woocommerce' ), '' );

				return;
			}

		}

		/*
		 * if description is available
		 * */
		if ( isset( $_POST['dokan_description'] ) )
		{
			update_user_meta( $current_user->ID, 'description', $_POST['dokan_description'] );
		}


		if ( ! isset( $_POST['dokan_store_name'] ) )
		{
			return;
		}

		$store_settings               = dokan_get_store_info( $current_user->ID );
		$store_settings['store_name'] = $_POST['dokan_store_name'];
		$store_settings['gravatar']   = $_POST['dokan_gravatar'];

		/*var_dump($_POST);

		exit;*/

		update_user_meta( $current_user->ID, 'dokan_profile_settings', $store_settings );

//		do_action( 'dokan_process_seller_meta_fields', $current_user->ID );
	}


	add_action( 'init', 'handle_woocommerce_billing_update' );
	function handle_woocommerce_billing_update()
	{

		if ( ! isset( $_POST['action'] ) )
		{
			return;
		}

		if ( $_POST['action'] == 'edit_address' )
		{
			$dokan_template_settings = Dokan_Template_Settings::init();
			$dokan_template_settings->insert_settings_info();
		}

	}

	add_action( 'wp_enqueue_scripts', 'mgt_dequeue_stylesandscripts', 100 );

	function mgt_dequeue_stylesandscripts()
	{
		if ( class_exists( 'woocommerce' ) )
		{
//			wp_dequeue_style( 'select2' );
//			wp_deregister_style( 'select2' );

			wp_dequeue_script( 'select2' );
			wp_deregister_script( 'select2' );

		}
	}


	/*
	 * Force THE Currency into USD after checkout process
	 * */
	add_action( 'woocommerce_checkout_process', 'revert_currency_to_usd', 5 );
	function revert_currency_to_usd()
	{
		$_SESSION['woocs_current_currency'] = 'USD';
	}


	/*from halawallah@mont8.com*/
	function from_halwallah_address()
	{
		return 'halawallah@mont8.com';
	}

	function from_shukran_address()
	{
		return 'shukran@mont8.com';
	}

	function from_habebe_address()
	{
		return 'habeebi@mont8.com';
	}

	function send_approve_product_email_to_seller( $post_ID, $post_after, $post_before )
	{

		if ( $post_before->post_status == 'pending' && $post_after->post_status == 'publish' )
		{
			( new IB_User() )->send_seller_product_approval_email( $post_after->post_author, $post_after );
		}

	}

	add_action( 'post_updated', 'send_approve_product_email_to_seller', 10, 3 );




