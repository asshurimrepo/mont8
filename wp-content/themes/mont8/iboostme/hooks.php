<?php
	/**
	 *
	 */
	define( 'THEME_PATH', get_template_directory_uri() );

	if ( $_REQUEST['action'] == 'like_artwork' )
	{
		add_action( 'wp_loaded', array( new Like_Artwork, 'init' ), 1 );
	}


	add_filter( 'woocommerce_login_redirect', 'mont_login_redirect' );

	function mont_login_redirect( $redirect_to )
	{

		$user = get_user_by( 'login', $_POST['username'] );

		if ( dokan_is_user_seller( $user->ID ) )
		{
			$redirect_to = dokan_get_navigation_url();
		}
		else
		{
			$redirect_to = get_permalink( get_page_by_path( 'my - orders' ) );
		}


		return $redirect_to;

	}


//	Get Base Price
	/**
	 * @param null $key
	 *
	 * @return mixed|void
	 */
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

	/**
	 * @param $class
	 *
	 * @return mixed
	 */
	function change_avatar_css( $class )
	{
		$class = str_replace( "class='avatar", "class='avatar img-circle", $class );

		return $class;
	}


	//	Disqus shortcode
	/**
	 * @param $disqus_shortname
	 */
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
	/**
	 *
	 */
	function upload_artwork_script()
	{

		load_js( 'handlebars', 'handlebars.js', '3.0.3' );

		load_js( 'new-product-script', 'new-product.js' );

//		load_js( 'jquery-cookie', 'jquery-cookie.js' );

		load_style( 'new-product-style', 'new-product.css', '1.0.2' );


	}


	// Load Edit Artwork Script
	/**
	 *
	 */
	function edit_artwork_script()
	{

		load_js( 'new-product-script', 'product-edit.js', '1.1.1' );

		load_style( 'new-product-style', 'new-product.css', '1.0.2' );
	}


	// Load Frame this print Script
	/**
	 *
	 */
	function product_framing_js_scripts()
	{
		// readmore js
		load_js( 'readmorejs', 'readmore.min.js' );

		// Framing Script
		load_js( 'framing-the-print-script', 'product-framing.js', '1.2.1' );

		// Preview on the wall script
		load_js( 'preview-on-the-wall', 'preview-on-the-wall.js', '1.2.1' );

		// load style
		load_style( 'single-product-style', 'style.css', '1.1.0' );

		// Multi zoom
		load_js( 'multizoom-script', 'multizoom.js' );
		load_style( 'multizoom-style', 'multizoom.css' );


	}


	/**
	 * @param $id
	 * @param $path
	 * @param string $version
	 */
	function load_js( $id, $path, $version = '1.0.0' )
	{
		wp_enqueue_script(
			$id,
			get_stylesheet_directory_uri() . "/iboostme/js/{$path}",
			array(), $version, true
		);
	}

	/**
	 * @param $id
	 * @param string $v
	 * @param array|[css, js] $is_included
	 */
	function load_plugin( $id, $v = '1.0.0', $is_included = [ 'css', 'js' ] )
	{
		if ( $is_included[0] )
		{
			load_style( "{$id}-style", "{$id}.css", $v );
		}

		if ( $is_included[1] )
		{
			load_js( "{$id}-script", "{$id}.js", $v );
		}
	}

	/**
	 * @param $id
	 * @param $path
	 * @param string $version
	 * @param string $dir
	 */
	function load_style( $id, $path, $version = '1.0.0', $dir = "/iboostme/css/" )
	{
		wp_enqueue_style(
			$id,
			get_stylesheet_directory_uri() . "{$dir}{$path}",
			array(), $version
		);
	}

	/**
	 * @param $src
	 *
	 * @return string
	 */
	function get_image( $src )
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/' . $src;
	}

	/**
	 *
	 */
	function load_product_page_assets()
	{
		add_action( 'wp_enqueue_scripts', 'product_framing_js_scripts' );
	}


	/**
	 * @return string
	 */
	function default_frame_art_thumb()
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/frame-thumb/flat-frameframe-brown.jpg';
	}

	/**
	 * @return string
	 */
	function default_frame_art_big()
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/frame-thumb/flat-frameframe-brown-big.jpg';
	}

	/**
	 * @return string
	 */
	function get_frame_art_dir()
	{
		return get_stylesheet_directory_uri() . '/iboostme/css/images/frame-thumb/';
	}


	/**
	 * @param $prod_id
	 *
	 * @return null|string
	 */
	function count_wishlist( $prod_id )
	{
		global $wpdb;

		return $wpdb->get_var( 'SELECT COUNT(*) as count FROM mo_yith_wcwl WHERE prod_id = ' . $prod_id );
	}

	/**
	 * @param null $author_id
	 *
	 * @return int|null|string
	 */
	function count_artwork( $author_id = null )
	{
		global $wpdb;

		if ( ! $author_id )
		{
			return 0;
		}

		return $wpdb->get_var( "SELECT COUNT(*) as count FROM mo_posts WHERE post_author = {$author_id} AND post_type = 'product' AND post_status='publish'" );
	}

	/**
	 * @param $atts
	 */
	function iboost_get_template_part( $atts )
	{
		$a = shortcode_atts( array(
			'foo' => 'something',
			'bar' => 'something else',
		), $atts );
	}

	/**
	 * @return string
	 */
	function current_url()
	{
		global $wp;

		return add_query_arg( $wp->query_string, '', home_url( $wp->request ) );
	}

	/**
	 * @return array|WP_Error
	 */
	function li()
	{
		return get_terms( [ 'product_tag' ] );
	}

	/**
	 * @param $path
	 * @param array $data
	 */
	function iboost_include( $path, $data = array() )
	{
		extract( $data );
		include( locate_template( "{$path}.php" ) );

		return;
	}


	/**
	 * @param $atts
	 *
	 * @return string
	 */
	function iboost_get_template( $atts )
	{
		$a = shortcode_atts( array(
			'template' => '',
		), $atts );

		ob_start();
		get_template_part( "iboostme/{$a[template]}" );
		$var = ob_get_contents();
		ob_end_clean();

		return $var;
	}

	add_shortcode( 'iboost_get_template', 'iboost_get_template' );


	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function a_link( $atts, $content = null )
	{
		$a = shortcode_atts( array(
			'href'  => '#!',
			'class' => '',
			'slug'  => '',
			'sub'   => ''
		), $atts );

		if ( $a['slug'] )
		{
			$a['href'] = get_permalink_by_slug( $a['slug'], $a['sub'] );
		}

		return '<a href="' . $a['href'] . '" class="' . $a['class'] . '">' . $content . '</a>';
	}

	add_shortcode( 'a', 'a_link' );


	/**
	 * @param $atts
	 *
	 * @return string
	 */
	function h_space( $atts )
	{

		$a = shortcode_atts( array(
			'size' => '10',
		), $atts );

		return '<div class="h_space" style="padding:' . $a['size'] . 'px"></div>';

	}

	add_shortcode( 'h_space', 'h_space' );

	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function h1( $atts, $content = null )
	{

		$a = shortcode_atts( array(
			'class' => '',
		), $atts );

		return '<h1 class="' . $a['class'] . '"><span>' . $content . '</span></h1>';

	}

	add_shortcode( 'h1', 'h1' );


//	ROW
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function row( $atts, $content = null )
	{
		$a = shortcode_atts( array(
			'style' => '',
		), $atts );

		return '<div class="row" style="' . $a['style'] . '">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'row', 'row' );

//  FontAwesome
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function fa( $atts, $content = null )
	{

		$a = shortcode_atts( array(
			'icon' => '',
		), $atts );

		return "<i style='margin: 0 10px;' class='fa fa-{$a[icon]}'></i>";
	}

	add_shortcode( 'fa', 'fa' );

//	DIV
	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function div( $atts, $content = null )
	{
		$a = shortcode_atts( array(
			'class' => '',
		), $atts );

		return '<div class="' . $a['class'] . '">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'div', 'div' );


	/**
	 * @param $atts
	 * @param null $content
	 *
	 * @return string
	 */
	function col_1_5( $atts, $content = null )
	{
		return '<div class="col-1-5">' . do_shortcode( $content ) . '</div>';
	}

	add_shortcode( 'col-1-5', 'col_1_5' );


	/**
	 * @param $menus
	 *
	 * @return mixed
	 */
	function dokan_add_dashboard_menu( $menus )
	{
		/*If user is not a seller*/
		if ( ! dokan_is_user_seller( get_current_user_id() ) )
		{
			$menus['my - account'] = array(
				'title' => __( 'My Account', 'dokan' ),
				'url'   => get_permalink( get_page_by_path( 'my - account' ) )
			);

			$menus['my - orders'] = array(
				'title' => __( 'My Orders', 'dokan' ),
				'url'   => get_permalink( get_page_by_path( 'my - orders' ) )
			);

			$menus['wishlist'] = array(
				'title' => __( 'My Wishlist', 'dokan' ),
				'url'   => get_permalink( get_page_by_path( 'wishlist' ) )
			);


			return $menus;
		}


		/*if user is a seller*/
		/*$menus['payments'] = array(
			'title' => __( 'Payments', 'dokan' ),
			'url'   => dokan_get_navigation_url( 'settings/payment' )
		);

		$menus['pricing'] = array(
			'title' => __( 'Pricing', 'dokan' ),
			'url'   => get_permalink( get_page_by_path( 'pricing' ) )
		);*/

		/*$menus['printshop'] = array(
			'title' => __( 'Printshop', 'dokan' ),
			'url'   => dokan_get_navigation_url( 'printshop' )
		);*/

		/*$menus['marketing'] = array(
			'title' => __( 'Marketing', 'dokan' ),
			'url'   => get_permalink( '' )
		);*/

		/*$menus['my - account'] = array(
			'title' => __( 'My Account', 'dokan' ),
			'url'   => get_permalink( get_page_by_path( 'my - account' ) )
		);*/

		$menus['wishlist'] = array(
			'title' => __( 'My Wishlist', 'dokan' ),
			'url'   => get_permalink( get_page_by_path( 'wishlist' ) )
		);


		return $menus;
	}

	add_filter( 'dokan_get_dashboard_nav', 'dokan_add_dashboard_menu' );


	/**
	 * @return array|WP_Error
	 */
	function get_product_tags()
	{
		$taxonomies = array(
			'product_tag',
		);

		return get_terms( $taxonomies );
	}


	/**
	 * @return string
	 */
	function get_migration_to_seller_url()
	{
		return dokan_get_page_url( 'myaccount', 'woocommerce' ) . 'account-migration/seller/';
	}


	/**
	 * @return bool|string
	 */
	function shop_url()
	{
		return get_permalink( get_page_by_path( 'shop' ) );
	}

	/**
	 * @return bool|null|string
	 */
	function get_my_account_url()
	{
		$myaccount_page_id = get_option( 'woocommerce_myaccount_page_id' );
		if ( $myaccount_page_id )
		{
			return get_permalink( $myaccount_page_id );
		}

		return null;
	}

	/**
	 * @param $slug
	 * @param null $sub
	 *
	 * @return string
	 */
	function get_permalink_by_slug( $slug, $sub = null )
	{
		return get_permalink( get_page_by_path( $slug ) ) . $sub;
	}

	/**
	 * @param $id
	 *
	 * @return bool
	 */
	function is_square( $id )
	{
		$image = wp_get_attachment_metadata( $id );

		if ( $image['width'] == $image['height'] )
		{
			return true;
		}

		return false;
	}


	/**
	 * @param null $key
	 *
	 * @return mixed
	 */
	function get_current_currency( $key = null )
	{
		global $WOOCS;
		$currencies = $WOOCS->get_currencies();
		$currency   = get_woocommerce_currency();

		if ( $key )
		{
			return $currencies[ $currency ][ $key ];
		}

		return $currencies[ $currency ];
	}

	function get_currency_by_name( $name, $key = null )
	{
		global $WOOCS;
		$currencies = $WOOCS->get_currencies();

		if ( $key )
		{
			return $currencies[ $name ][ $key ];
		}

		return $currencies[ $name ];
	}


	//Validate Edit Account
	add_action( 'user_profile_update_errors', 'validate_store_info_upon_saving', 10, 1 );
	/**
	 * @param $args
	 */
	function validate_store_info_upon_saving( $args )
	{

		global $current_user;

		if ( isset( $_POST['dokan_store_name'] ) )
		{
			if ( strlen( $_POST['dokan_store_name'] ) < 1 )
			{
				$args->add( 'error', __( 'Store Name is required!', 'woocommerce' ), '' );

				return;
			}

		}


		if ( strlen( $_POST['dokan_description'] ) < 1 )
		{
			$args->add( 'error', __( 'Store Description is required!', 'woocommerce' ), '' );

			return;
		}

		update_user_meta( $current_user->ID, 'description', $_POST['dokan_description'] );

		if ( ! isset( $_POST['dokan_store_name'] ) )
		{
			return;
		}

		$store_settings               = dokan_get_store_info( $current_user->ID );
		$store_settings['store_name'] = $_POST['dokan_store_name'];
		$store_settings['gravatar'] = $_POST['dokan_gravatar'];

		/*var_dump($_POST);

		exit;*/

		update_user_meta( $current_user->ID, 'dokan_profile_settings', $store_settings );

//		do_action( 'dokan_process_seller_meta_fields', $current_user->ID );
	}


	add_filter( 'woocommerce_get_item_data', 'add_weight_to_item_data', 999, 2 );
	/**
	 * @param $a
	 * @param string $cart_item
	 *
	 * @return array
	 */
	function add_weight_to_item_data( $a, $cart_item = '' )
	{
		$store_url = dokan_get_store_url( $cart_item['data']->post->post_author );

		if ( $a[0]['name'] == 'Seller' )
		{
			$a[0]['value'] = '<a href="' . $store_url . '">' . $a[0]['value'] . '</a>';
		}


		$a[] = [
			'name'  => 'Weight',
			'value' => MontWeightCalculator::getWeightBySize( $cart_item )
		];

		return $a;
	}

	add_filter( 'formatted_woocommerce_price', 'round_formatted_woocommerce_price', 999 );
	/**
	 * @param $price
	 *
	 * @return string
	 */
	function round_formatted_woocommerce_price( $price )
	{

		/*$price = str_replace( ',', '', $price );

		return number_format( round( $price ), 2 );*/

		return $price;
	}


	/*add_filter( 'woocommerce_get_price_excluding_tax', 'round_price_product', 10, 1 );
	add_filter( 'woocommerce_get_price_including_tax', 'round_price_product', 10, 1 );
	add_filter( 'woocommerce_tax_round', 'round_price_product', 10, 1);
	add_filter( 'woocommerce_get_price', 'round_price_product', 10, 1);

	function round_price_product( $price ){
		return round( $price );
	}*/


	add_action( 'woocommerce_checkout_process', 'validate_shipping' );
	add_action( 'woocommerce_checkout_process', 'validate_shipping_if_cod' );
	add_action( 'woocommerce_checkout_update_order_review', 'update_shipping_rate', 1 );


	add_filter( 'woocommerce_available_payment_gateways', 'filter_gateways', 1 );


	function update_shipping_rate()
	{
//		WC()->shipping()->reset_shipping();
	}

	/**
	 * @param $gateways
	 *
	 * @return mixed
	 */
	function filter_gateways( $gateways )
	{
		$package     = end( WC()->cart->get_shipping_packages() );
		$countryCode = $package['destination']['country'];

		$available_countries_for_cod = [

			'ae',
			'bh',
			'kw',
			'om',
			'qa',
			'sa',

		];

		if ( in_array( strtolower( $countryCode ), $available_countries_for_cod ) )
		{
			return $gateways;
		}

		unset( $gateways['cod'] );

		return $gateways;
	}

	/**
	 *
	 */
	function validate_shipping_if_cod()
	{
		$payment_method = $_POST['payment_method'];

		if ( $payment_method != 'cod' )
		{
			return;
		}

		$package       = end( WC()->cart->get_shipping_packages() );
		$countryCode   = $package['destination']['country'];
		$total         = WC()->cart->total;
		$currency_rate = get_current_currency( 'rate' );
		$max_amount    = $countryCode == 'AE' ? 2500 : 1835;
		$max_amount *= $currency_rate;
		$total *= $currency_rate;

		$currency_name = get_current_currency( 'name' );

		if ( $total > $max_amount )
		{
			$max_amount = ceil( $max_amount );

			wc_add_notice(
				sprintf( "<b>Exceeding Maximum Amount!</b> You are only allowed to checkout a maximum of <b>{$max_amount} {$currency_name}</b>"
				), 'error'
			);
		}

	}

	/**
	 *
	 */
	function validate_shipping()
	{
		$shipping = new AramexShippingRates( end( WC()->cart->get_shipping_packages() ) );

		if ( $shipping->errors() )
		{
			wc_add_notice(
				sprintf( "<b>{$shipping->errors()->Code}!</b> {$shipping->errors()->Message}"
				), 'error'
			);
		}

	}