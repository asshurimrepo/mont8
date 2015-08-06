<?php


//	add_action( 'wp_loaded', 'load_wp' );

	function load_wp()
	{
		$tm_meta = get_post_meta( 121, 'tm_meta', true );


		var_dump( $tm_meta['tmfbuilder'] );

//		$base_prices->framed
		exit;
	}
