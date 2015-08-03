<?php


//	add_action( 'wp_loaded', 'load_wp' );

	function load_wp()
	{
		$count_posts = wp_count_posts( 'product' );
		var_dump( $count_posts );

//		exit;
	}