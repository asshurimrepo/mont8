<?php

//	require_once('class/global_pricing.php');

// Constants
	define( 'THEME_PATH', get_template_directory_uri() );


//	Init
	function init_mont8()
	{

		if ( get_option( '_art_print_base_prices' ) )
		{
			return;
		}

		$base_price = [
			'framed_print' => [ 70, 319 ],
			'art_print'    => [ 33, 170 ],
			'photo_print'  => [ 38, 195 ],
			'canvas'       => [ 181, 564 ],
			'poster'       => [ 54, 90 ]
		];

		update_option( '_art_print_base_prices', json_encode( $base_price ) );
	}

	add_action( 'init', 'init_mont8' );


//	Get Base Price
	function get_base_price( $key = null )
	{
		$base_prices = get_option( '_art_print_base_prices' );
		$base_prices = json_decode( $base_prices );

		if ( ! $key )
		{
			return $base_prices;
		}

//		var_dump($base_prices);

		return $base_prices->{$key};
	}

// Change avatar css
	add_filter( 'get_avatar', 'change_avatar_css' );

	function change_avatar_css( $class )
	{
		$class = str_replace( "class='avatar", "class='avatar img-circle", $class );

		return $class;
	}


	//	Disqus shortcode
	function disqus_embed( $disqus_shortname )
	{
		global $post;
		wp_enqueue_script( 'disqus_embed', 'http://' . $disqus_shortname . '.disqus.com/embed.js' );
		echo '<div id="disqus_thread"></div>
		    <script type="text/javascript">
		        var disqus_shortname = "' . $disqus_shortname . '";
		        var disqus_title = "' . $post->post_title . '";
		        var disqus_url = "' . get_permalink( $post->ID ) . '";
		        var disqus_identifier = "' . $disqus_shortname . '-' . $post->ID . '";
		    </script> <div class="disqus-hider">&nbsp;</div>';
	}

	// Load Upload Artwork Script
	function upload_artwork_script()
	{

		load_js( 'handlebars', 'handlebars.js', '3.0.3' );

		load_js( 'new-product-script', 'new-product.js' );

		load_style( 'new-product-style', 'new-product.css', '1.0.2' );


	}


	// Load Edit Artwork Script
	function edit_artwork_script()
	{

		load_js( 'new-product-script', 'product-edit.js', '1.1.1' );

		load_style( 'new-product-style', 'new-product.css', '1.0.2' );
	}


	// Load Frame this print Script
	function product_framing_js_scripts()
	{
		// readmore js
		load_js( 'readmorejs', 'readmore.min.js' );

		// Framing Script
		load_js( 'framing-the-print-script', 'product-framing.js' );

		// load style
		load_style( 'single-product-style', 'style.css', '1.0.6' );

	}


	function load_js( $id, $path, $version = '1.0.0' )
	{
		wp_enqueue_script(
			$id,
			get_stylesheet_directory_uri() . "/iboostme/js/{$path}",
			array(), $version, true
		);
	}

	function load_style( $id, $path, $version = '1.0.0' )
	{
		wp_enqueue_style(
			$id,
			get_stylesheet_directory_uri() . "/iboostme/css/{$path}",
			array(), $version
		);
	}

	function get_image( $src )
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/' . $src;
	}

	function load_product_page_assets()
	{
		add_action( 'wp_enqueue_scripts', 'product_framing_js_scripts' );
	}


	function default_frame_art_thumb()
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/frame-thumb/flat-frameframe-brown.jpg';
	}

	function default_frame_art_big()
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/frame-thumb/flat-frameframe-brown-big.jpg';
	}

	function get_frame_art_dir()
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/frame-thumb/';
	}


	function count_wishlist( $prod_id )
	{
		global $wpdb;

		return $wpdb->get_var( 'SELECT COUNT(*) as count FROM mo_yith_wcwl WHERE prod_id = ' . $prod_id );
	}

	function count_artwork( $author_id = null )
	{
		global $wpdb;

		if ( ! $author_id )
		{
			return 0;
		}

		return $wpdb->get_var( "SELECT COUNT(*) as count FROM mo_posts WHERE post_author = {$author_id} AND post_type = 'product' AND post_status='publish'" );
	}

	function iboost_get_template_part( $atts )
	{
		$a = shortcode_atts( array(
			'foo' => 'something',
			'bar' => 'something else',
		), $atts );
	}

	function current_url()
	{
		global $wp;

		return add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
	}

	function li()
	{
		return get_terms( [ 'product_tag' ] );
	}

	function iboost_include( $path, $data = array() )
	{
		extract( $data );
		include( locate_template( "{$path}.php" ) );

		return;
	}


	function iboost_get_template( $atts )
	{
		$a = shortcode_atts( array(
			'template' => '',
		), $atts );

		return get_template_part( "iboostme/{$a[template]}" );
	}

	add_shortcode( 'iboost_get_template', 'iboost_get_template' );


	function dokan_add_dashboard_menu( $menus )
	{

		$menus['payments'] = array(
			'title' => __( 'Payments', 'dokan' ),
			'url'   => dokan_get_navigation_url( 'settings/payment' )
		);

		$menus['pricing'] = array(
			'title' => __( 'Pricing', 'dokan' ),
			'url'   => get_permalink( get_page_by_path( 'pricing' ) )
		);

		$menus['printshop'] = array(
			'title' => __( 'Printshop', 'dokan' ),
			'url'   => dokan_get_navigation_url( 'printshop' )
		);

		$menus['marketing'] = array(
			'title' => __( 'Marketing', 'dokan' ),
			'url'   => get_permalink( '' )
		);

		$menus['my-account'] = array(
			'title' => __( 'My Account', 'dokan' ),
			'url'   => get_permalink( get_page_by_path( 'my-account' ) )
		);


		return $menus;
	}

	add_filter( 'dokan_get_dashboard_nav', 'dokan_add_dashboard_menu' );


	function get_product_tags()
	{
		$taxonomies = array(
			'product_tag',
		);

		return get_terms( $taxonomies );
	}


	function get_my_account_url()
	{
		$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
		if ( $myaccount_page_id )
		{
			return get_permalink( $myaccount_page_id );
		}

		return null;
	}
	