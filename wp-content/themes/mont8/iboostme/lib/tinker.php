<?php


//	add_action( 'wp_loaded', 'load_wp' );

	function load_wp()
	{
		$user = get_userdata( 1 );

		var_dump( $user->user_login );

//		$base_prices->framed
		exit;
	}
