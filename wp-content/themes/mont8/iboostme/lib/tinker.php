<?php


//	add_action( 'wp_loaded', 'load_wp' );

	function load_wp()
	{
		$user = get_user_by( 'id', get_current_user_id() );
		var_dump( $user->last_name );
	}