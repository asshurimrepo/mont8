<?php
	/*
	 * Handles any login concerning uploading new artwork
	 * */


	add_filter( 'wp_handle_upload_prefilter', 'tc_handle_upload_prefilter' );
	function tc_handle_upload_prefilter( $file )
	{
		global $current_user;
		$user_roles = $current_user->roles;
		$user_role  = array_shift( $user_roles );

		/*Continue if not seller*/
		if ( $user_role == 'administrator' )
		{
			return $file;
		}

		$img    = getimagesize( $file['tmp_name'] );
		$width  = $img[0];
		$height = $img[1];


		if ( $width == $height )
		{
			return add_square_artwork( $file );
		}


		return add_A_size_artwork( $file );
		/*array (size=5)
		  'name' => string '11693860_1092529837427287_112765294966082361_n.jpg' (length=50)
		  'type' => string 'image/jpeg' (length=10)
		  'tmp_name' => string '/tmp/php6BLk9a' (length=14)
		  'error' => int 0
		  'size' => int 34564*/


	}


	function add_square_artwork( $file )
	{
		$img    = getimagesize( $file['tmp_name'] );
		$width  = $img[0];
		$height = $img[1];

		$minimum = 1772;

		if ( $width < $minimum )
		{
			return [ 'error' => "Image dimensions are too small for required squared artwork. Minimum width is {$minimum['width']}px. Uploaded image width is $width px", ];
		}


		return $file;
	}


	function add_A_size_artwork( $file )
	{
		$img    = getimagesize( $file['tmp_name'] );
		$width  = $img[0];
		$height = $img[1];

		$is_portrait = $width < $height ? true : false;

		$minimum_portrait  = array( 'width' => '1240', 'height' => '1754' );
		$minimum_landscape = array( 'width' => '1754', 'height' => '1240' );

		$minimum = $is_portrait ? $minimum_portrait : $minimum_landscape;

		$base_w = 3508;
		$base_h = 4967;

		$portrait_ratio  = substr( $base_w / $base_h, 0, 4 );
		$landscape_ratio = substr( $base_h / $base_w, 0, 4 );

		$required_ratio = $is_portrait ? $portrait_ratio : $landscape_ratio;
		$file_ratio     = substr( $width / $height, 0, 4 );

		if ( $file_ratio != $required_ratio )
		{
			return [ 'error' => " your artwork size doesn't qualify the required minimum dimensions click here for more information about uploading guidelines", ];
		}

		if ( $width < $minimum['width'] )
		{
			return array( "error" => "Image dimensions are too small. Minimum width is {$minimum['width']}px. Uploaded image width is $width px" );
		}

		elseif ( $height < $minimum['height'] )
		{
			return array( "error" => "Image dimensions are too small. Minimum height is {$minimum['height']}px. Uploaded image height is $height px" );
		}
		else
		{
			return $file;
		}
	}


	add_filter( 'upload_size_limit', 'set_upload_size_limit' );
	function set_upload_size_limit()
	{
		return 5000000;
	}

	function my_myme_types( $mime_types )
	{

		global $current_user;
		$user_roles = $current_user->roles;
		$user_role  = array_shift( $user_roles );

		/*Continue if not seller*/
		if ( $user_role == 'administrator' )
		{
			return $mime_types;
		}

		//Creating a new array will reset the allowed filetypes
		$mime_types = array(
			'jpg|jpeg|jpe' => 'image/jpeg',
			'png'          => 'image/png',
		);

		return $mime_types;
	}

	add_filter( 'upload_mimes', 'my_myme_types', 1, 1 );

	//	upload_size_limit_filter( 5000000 );