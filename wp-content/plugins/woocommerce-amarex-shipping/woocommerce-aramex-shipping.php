<?php
	/*
	Plugin Name: Woocommerce Aramex Shipping Integration
	Plugin URI: http://woothemes.com/woocommerce
	Description: Aramex Shipping Rates API Integration to Woocommerce
	Version: 1.0.0
	Author: iBoostme
	Author URI: http://woothemes.com
	*/

	/**
	 * Check if WooCommerce is active
	 */
	if ( in_array( 'woocommerce/woocommerce.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) )
	{

		function aramex_shipping_method_init()
		{
			if ( ! class_exists( 'WC_Aramex_Shipping_Method' ) )
			{
				class WC_Aramex_Shipping_Method extends WC_Shipping_Method {
					/**
					 * Constructor for your shipping class
					 *
					 * @access public
					 */
					public function __construct()
					{
						$this->id                 = 'aramex'; // Id for your shipping method. Should be uunique.
						$this->method_title       = __( 'Aramex' );  // Title shown in admin
						$this->method_description = __( 'Aramex Rates API' ); // Description shown in admin

						$this->enabled = "yes"; // This can be added as an setting but for this example its forced enabled
						$this->title   = "Aramex"; // This can be added as an setting but for this example its forced.

						$this->init();
					}

					/**
					 * Init your settings
					 *
					 * @access public
					 * @return void
					 */
					function init()
					{
						// Load the settings API
						$this->init_form_fields(); // This is part of the settings API. Override the method to add your own settings
						$this->init_settings(); // This is part of the settings API. Loads settings you previously init.

						// Save settings in admin if you have any defined
						add_action( 'woocommerce_update_options_shipping_' . $this->id, array(
							$this,
							'process_admin_options'
						) );
					}

					/**
					 * calculate_shipping function.
					 *
					 * @access public
					 *
					 * @param mixed $package
					 *
					 * @return void
					 */
					public function calculate_shipping( $package )
					{

						$shipping = new AramexShippingRates( $package );

						if ( $shipping->errors() )
						{
							return;
						}

						$rate = array(
							'id'       => $this->id,
							'label'    => $this->title,
							'cost' => $shipping->getFinalAmount(),
							'calc_tax' => 'per_item'
						);


						/*//Free Shipping if total weight is > 15KG
						if ( $shipping->getTotalWeight() >= 15 )
						{
							$rate['cost'] = 0;
						}*/

						// Register the rate
						$this->add_rate( $rate );

					}


				}
			}
		}

		add_action( 'woocommerce_shipping_init', 'aramex_shipping_method_init' );

		function add_aramex_shipping_method( $methods )
		{
			$methods[] = 'WC_Aramex_Shipping_Method';

			return $methods;
		}

		add_filter( 'woocommerce_shipping_methods', 'add_aramex_shipping_method' );
	}


	//	add_action( 'woocommerce_before_cart' , 'wc_minimum_order_amount' );




