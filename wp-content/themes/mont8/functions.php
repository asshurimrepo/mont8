<?php
	require_once( 'vendor/autoload.php' );
	require_once( 'iboostme/constants.php' );
	require_once( 'iboostme/hooks.php' );


	/**
	 * Dokan functions and definitions
	 *
	 * @package Dokan
	 * @since Dokan 1.0
	 */

	/**
	 * Set the content width based on the theme's design and stylesheet.
	 *
	 * @since Dokan 1.0
	 */

	if ( ! isset( $content_width ) )
	{
		$content_width = 640;
	}


	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * @since Dokan 1.0
	 */
	class WeDevs_Dokan_Theme {

		function __construct()
		{

			//includes file
			$this->includes();

			// init actions and filter
			$this->init_filters();
			$this->init_actions();

			// initialize classes
			$this->init_classes();
		}

		/**
		 * Initialize filters
		 *
		 * @return void
		 */
		function init_filters()
		{
			add_filter( 'wp_title', array( $this, 'wp_title' ), 10, 2 );
		}

		/**
		 * Init action hooks
		 *
		 * @return void
		 */
		function init_actions()
		{
			add_action( 'after_setup_theme', array( $this, 'setup' ) );
			add_action( 'widgets_init', array( $this, 'widgets_init' ) );

			add_action( 'wp_enqueue_scripts', array( $this, 'scripts' ) );
			add_action( 'dokan_admin_menu', array( $this, 'slider_page' ) );
		}

		public function init_classes()
		{
			Dokan_Slider::init();
		}


		function includes()
		{
			$lib_dir     = __DIR__ . '/lib/';
			$inc_dir     = __DIR__ . '/includes/';
			$classes_dir = __DIR__ . '/classes/';

			require_once $classes_dir . 'slider.php';

			require_once $inc_dir . 'wc-functions.php';
			require_once $inc_dir . 'wc-template.php';

			if ( is_child_theme() && file_exists( get_stylesheet_directory() . '/classes/customizer.php' ) )
			{
				require_once get_stylesheet_directory() . '/classes/customizer.php';
			}
			else
			{
				require_once $classes_dir . 'customizer.php';
			}

			if ( is_admin() )
			{

			}
			else
			{
				require_once $lib_dir . 'bootstrap-walker.php';
				require_once $inc_dir . 'template-tags.php';
			}
		}

		/**
		 * Setup dokan
		 *
		 * @uses `after_setup_theme` hook
		 */
		function setup()
		{

			/**
			 * Make theme available for translation
			 * Translations can be filed in the /languages/ directory
			 */
			load_theme_textdomain( 'dokan', get_template_directory() . '/languages' );

			/**
			 * Add default posts and comments RSS feed links to head
			 */
			add_theme_support( 'automatic-feed-links' );

			/**
			 * Enable support for Post Thumbnails
			 */
			add_theme_support( 'post-thumbnails' );

			/**
			 * This theme uses wp_nav_menu() in one location.
			 */
			register_nav_menus( array(
				'primary'  => __( 'Primary Menu', 'dokan' ),
				'top-left' => __( 'Top Left', 'dokanmmm_fullwidth_container' ),
				'footer'   => __( 'Footer Menu', 'dokan' ),
			) );

			add_theme_support( 'woocommerce' );

			/*
			 * This theme supports custom background color and image,
			 * and here we also set up the default background color.
			 */
			add_theme_support( 'custom-background', array(
				'default-color' => 'F7F7F7',
			) );

			add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list' ) );
		}

		/**
		 * Register widgetized area and update sidebar with default widgets
		 *
		 * @since Dokan 1.0
		 */
		function widgets_init()
		{

			$sidebars = array(
				array( 'name' => __( 'General Sidebar', 'dokan' ), 'id' => 'sidebar-1' ),
				array( 'name' => __( 'Home Sidebar', 'dokan' ), 'id' => 'sidebar-home' ),
				array( 'name' => __( 'Blog Sidebar', 'dokan' ), 'id' => 'sidebar-blog' ),
				array( 'name' => __( 'Header Sidebar', 'dokan' ), 'id' => 'sidebar-header' ),
				array( 'name' => __( 'Shop Archive', 'dokan' ), 'id' => 'sidebar-shop' ),
				array( 'name' => __( 'Single Product', 'dokan' ), 'id' => 'sidebar-single-product' ),
				array( 'name' => __( 'Store', 'dokan' ), 'id' => 'sidebar-store' ),
				array( 'name' => __( 'Footer Sidebar - 1', 'dokan' ), 'id' => 'footer-1' ),
				array( 'name' => __( 'Footer Sidebar - 2', 'dokan' ), 'id' => 'footer-2' ),
				array( 'name' => __( 'Footer Sidebar - 3', 'dokan' ), 'id' => 'footer-3' ),
				array( 'name' => __( 'Footer Sidebar - 4', 'dokan' ), 'id' => 'footer-4' ),
			);

			$args = apply_filters( 'dokan_widget_args', array(
				'before_widget' => '<aside id="%1$s" class="widget %2$s">',
				'after_widget'  => '</aside>',
				'before_title'  => '<h3 class="widget-title">',
				'after_title'   => '</h3>',
			) );

			foreach ( $sidebars as $sidebar )
			{

				$args['name'] = $sidebar['name'];
				$args['id']   = $sidebar['id'];

				register_sidebar( $args );
			}
		}

		/**
		 * Enqueue scripts and styles
		 *
		 * @since Dokan 1.0
		 */
		function scripts()
		{

			$protocol           = is_ssl() ? 'https' : 'http';
			$template_directory = get_template_directory_uri();
			$skin               = get_theme_mod( 'color_skin', 'orange.css' );

			// register styles

			wp_enqueue_style( 'animate', $template_directory . '/assets/css/animate.css', false, null );
			wp_enqueue_style( 'cart-sidebar', $template_directory . '/assets/css/cart-sidebar.css', false, null );
			wp_enqueue_style( 'bootstrap-datepicker', $template_directory . '/assets/js/bootstrap-datepicker/css/bootstrap-datepicker.min.css', false, null );
			wp_enqueue_style( 'bootstrap', $template_directory . '/assets/css/bootstrap.css', false, null );
			wp_enqueue_style( 'flexslider', $template_directory . '/assets/css/flexslider.css', false, null );
			wp_enqueue_style( 'fontawesome', $template_directory . '/assets/css/font-awesome.min', false, null );
			wp_enqueue_style( 'dokan-opensans', $protocol . '://fonts.googleapis.com/css?family=Open+Sans:400,700' );
			wp_enqueue_style( 'dokan-theme', $template_directory . '/style.css', false, null );
			wp_enqueue_style( 'dokan-theme-skin', $template_directory . '/assets/css/skins/' . $skin, false, null );

			/*if ( is_user_logged_in() )
			{
				load_style( 'user-logged-in-style', 'user-logged.css', '1.0.1' );
			}*/


			/****** Scripts ******/
			if ( is_single() && comments_open() && get_option( 'thread_comments' ) )
			{
				wp_enqueue_script( 'comment-reply' );
			}

			if ( is_singular() && wp_attachment_is_image() )
			{
				wp_enqueue_script( 'keyboard-image-navigation', $template_directory . '/assets/js/keyboard-image-navigation.js', array( 'jquery' ), '20120202' );
			}

			wp_enqueue_script( 'jquery' );
			wp_enqueue_script( 'jquery-ui' );

			wp_enqueue_script( 'bootstrap-min', $template_directory . '/assets/js/bootstrap.min.js', false, null, true );
			wp_enqueue_script( 'flexslider', $template_directory . '/assets/js/jquery.flexslider-min.js', array( 'jquery' ) );

			wp_enqueue_script( 'dokan-theme-scripts', $template_directory . '/assets/js/script.js', false, null, true );
			wp_enqueue_script( 'bootstrap-datepicker-scripts', $template_directory . '/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js', false, null, true );
		}

		/**
		 * Create a nicely formatted and more specific title element text for output
		 * in head of document, based on current view.
		 *
		 * @since Dokan 1.0.4
		 *
		 * @param string $title Default title text for current view.
		 * @param string $sep Optional separator.
		 *
		 * @return string The filtered title.
		 */
		function wp_title( $title, $sep )
		{
			global $paged, $page;

			if ( is_feed() )
			{
				return $title;
			}

			// Add the site name.
			$title .= get_bloginfo( 'name' );

			// Add the site description for the home/front page.
			$site_description = get_bloginfo( 'description', 'display' );
			if ( $site_description && ( is_home() || is_front_page() ) )
			{
				$title = "$title $sep $site_description";
			}

			// Add a page number if necessary.
			if ( $paged >= 2 || $page >= 2 )
			{
				$title = "$title $sep " . sprintf( __( 'Page %s', 'dokan' ), max( $paged, $page ) );
			}

			return $title;
		}

		public function slider_page()
		{
			add_submenu_page( 'dokan', __( 'Slider', 'dokan' ), __( 'Slider', 'dokan' ), 'manage_options', 'edit.php?post_type=dokan_slider' );
		}

	}

	$dokan = new WeDevs_Dokan_Theme();

	//add_action( 'dokan_new_product_added', 'dokan_create_variable_product', 2, 10 );


	function dokan_child_get_seller_commission_by_order( $order_id )
	{
		global $wpdb;

		$order             = new WC_Order( $order_id );
		$seller_commission = 0;
		$items             = $order->get_items();

		foreach ( $items as $item )
		{
			$variation_id = $item['variation_id'];
			$seller_commission += get_post_meta( $variation_id, 'seller_commission', true );
		}

		return $seller_commission;
	}

	remove_action( 'woocommerce_checkout_update_order_meta', 'dokan_sync_insert_order' );
	remove_action( 'dokan_checkout_update_order_meta', 'dokan_sync_insert_order' );
	add_action( 'woocommerce_checkout_update_order_meta', 'dokan_child_sync_insert_order' );
	add_action( 'dokan_checkout_update_order_meta', 'dokan_child_sync_insert_order' );

	/**
	 * Insert a order in sync table once a order is created
	 *
	 * @global object $wpdb
	 *
	 * @param int $order_id
	 */
	function dokan_child_sync_insert_order( $order_id )
	{
		global $wpdb;

		$order             = new WC_Order( $order_id );
		$seller_commission = dokan_child_get_seller_commission_by_order( $order_id );
		$seller_id         = dokan_get_seller_id_by_order( $order_id );
		$order_total       = $order->get_total();
		$order_status      = $order->post_status;

		$wpdb->insert( $wpdb->prefix . 'dokan_orders',
			array(
				'order_id'     => $order_id,
				'seller_id'    => $seller_id,
				'order_total'  => $order_total,
				'net_amount'   => $seller_commission,
				'order_status' => $order_status,
			),
			array(
				'%d',
				'%d',
				'%f',
				'%f',
				'%s',
			)
		);
	}

	add_action( 'dokan_seller_dashboard_widget_counter', 'dokan_child_seller_earning' );

	function dokan_child_seller_earning()
	{
		?>
		<li>
			<div class="title"><?php _e( 'Earnings', 'dokan' ); ?></div>
			<div class="count"><?php echo dokan_get_seller_balance( get_current_user_id() ); ?></div>
		</li>
		<?php
	}

	add_filter( 'dokan-seller-dashboard-reports-left-sidebar', 'dokan_child_seller_commission_report_add' );
	function dokan_child_seller_commission_report_add( $legend )
	{

		$new_legend = array_slice( $legend, 0, 1, true ) +
		              array(
			              "earning_in_this_period" => array(
				              'title' => sprintf( __( '%s earning in this period', 'dokan' ), '<strong>' . dokan_get_seller_balance( get_current_user_id() ) . '</strong>' ),
			              )
		              ) +
		              array_slice( $legend, 1, count( $legend ) - 1, true );

		return $new_legend;
	}

	function vd( $val )
	{
		echo '<pre>';
		var_dump( $val );
		echo '</pre>';
	}

//--------------------------------------------------


	/**
	 * Prints seller info in product single page
	 *
	 * @global WC_Product $product
	 *
	 * @param type $val
	 */
	function mont_product_seller_tab()
	{
		global $product;

		$author     = get_user_by( 'id', $product->post->post_author );
		$store_info = dokan_get_store_info( $author->ID );


		?>
		<ul class="list-unstyled">
			testing
			<li class="seller-name">
            <span>
                <?php _e( '', 'dokan' ); ?>
            </span>

            <span class="details">
                <?php printf( '<a href="%s">%s</a>', dokan_get_store_url( $author->ID ), $author->display_name ); ?>
            </span>
			</li>
			<?php if ( ! empty( $store_info['address'] ) )
			{ ?>
				<li class="store-address">
					<span><?php _e( 'Address:', 'dokan' ); ?></span>
                <span class="details">
                    <?php echo esc_html( $store_info['address'] ); ?>
                </span>
				</li>
			<?php } ?>

		</ul>

		<?php
	}


	/**
	 * @desc Remove in all product type
	 */
	function wc_remove_all_quantity_fields( $return, $product )
	{
		return true;
	}

	add_filter( 'woocommerce_is_sold_individually', 'wc_remove_all_quantity_fields', 10, 2 );


	add_action( 'init', 'jk_remove_wc_breadcrumbs' );
	function jk_remove_wc_breadcrumbs()
	{
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20, 0 );
	}

	function mont_get_dashboard_nav()
	{
		$urls = array(
			'dashboard' => array(
				'title' => __( 'Dashboard', 'dokan' ),
				'icon'  => '<i class="fa fa-tachometer"></i>',
				'url'   => dokan_get_navigation_url()
			),
			'product'   => array(
				'title' => __( 'Products', 'dokan' ),
				'icon'  => '<i class="fa fa-briefcase"></i>',
				'url'   => dokan_get_navigation_url( 'products' )
			)
		);


		$urls = apply_filters( 'mont_get_dashboard_nav', $urls );

		$urls['settings'] = array(
			'title' => __( 'Settings', 'dokan' ),
			'icon'  => '<i class="fa fa-cog"></i>',
			'url'   => dokan_get_navigation_url( 'settings' )
		);


		return $urls;
	}


	function mont_seller_reg_form_fields()
	{
		$role       = isset( $_POST['role'] ) ? $_POST['role'] : 'customer';
		$role_style = ( $role == 'customer' ) ? ' style="display:none"' : '';
		?>
		<div class="show_if_seller"<?php echo $role_style; ?>>

			<div class="split-row form-row-wide">
				<p class="form-row form-group">
					<label for="first-name"><?php _e( 'First Name', 'dokan' ); ?> <span
							class="required">*</span></label>
					<input type="text" class="input-text form-control" name="fname" id="first-name"
					       value="<?php if ( ! empty( $_POST['fname'] ) )
					       {
						       echo esc_attr( $_POST['fname'] );
					       } ?>" required/>
				</p>

				<p class="form-row form-group">
					<label for="last-name"><?php _e( 'Last Name', 'dokan' ); ?> <span class="required">*</span></label>
					<input type="text" class="input-text form-control" name="lname" id="last-name"
					       value="<?php if ( ! empty( $_POST['lname'] ) )
					       {
						       echo esc_attr( $_POST['lname'] );
					       } ?>" required/>
				</p>
			</div>

			<p class="form-row form-group form-row-wide">
				<label for="company-name"><?php _e( 'Shop Name', 'dokan' ); ?> <span class="required">*</span></label>
				<input type="text" class="input-text form-control" name="shopname" id="company-name"
				       value="<?php if ( ! empty( $_POST['shopname'] ) )
				       {
					       echo esc_attr( $_POST['shopname'] );
				       } ?>" required/>
			</p>

			<p class="form-row form-group form-row-wide">
				<label for="seller-url" class="pull-left"><?php _e( 'Shop URL', 'dokan' ); ?> <span
						class="required">*</span></label>
				<strong id="url-alart-mgs" class="pull-right"></strong>
				<input type="text" class="input-text form-control" name="shopurl" id="seller-url"
				       value="<?php if ( ! empty( $_POST['shopurl'] ) )
				       {
					       echo esc_attr( $_POST['shopurl'] );
				       } ?>" required/>
				<small><?php echo home_url() . '/' . dokan_get_option( 'custom_store_url', 'dokan_selling', 'store' ); ?>
					/<strong id="url-alart"></strong></small>
			</p>

			<p class="form-row form-group form-row-wide">
				<label for="seller-address"><?php _e( 'Address', 'dokan' ); ?><span class="required">*</span></label>
				<textarea type="text" id="seller-address" name="address" class="form-control input"
				          required><?php if ( ! empty( $_POST['address'] ) )
					{
						echo esc_textarea( $_POST['address'] );
					} ?></textarea>
			</p>

			<p class="form-row form-group form-row-wide">
				<label for="shop-phone"><?php _e( 'Phone', 'dokan' ); ?><span class="required">*</span></label>
				<input type="text" class="input-text form-control" name="phone" id="shop-phone"
				       value="<?php if ( ! empty( $_POST['phone'] ) )
				       {
					       echo esc_attr( $_POST['phone'] );
				       } ?>" required/>
			</p>

			<?php do_action( 'dokan_seller_registration_field_after' ); ?>

		</div>

		<?php do_action( 'dokan_reg_form_field' ); ?>

		<p class="form-row form-group user-role">
			<label class="radio">
				<input type="radio" name="role" value="customer"<?php checked( $role, 'customer' ); ?>>
				<?php _e( 'I am a customer', 'dokan' ); ?>
			</label>

			<label class="radio">
				<input type="radio" name="role" value="seller"<?php checked( $role, 'seller' ); ?>>
				<?php _e( 'I am a seller', 'dokan' ); ?>
			</label>
			<?php do_action( 'dokan_registration_form_role', $role ); ?>
		</p>

		<?php
	}