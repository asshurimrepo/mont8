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

//						var_dump( $package );
//						var_dump( MontWeightCalculator::set( $package['contents'] )->getTotalWeights() );
//						unset( $_SESSION['aramex_shipping_notification'] );

						/*$dest_country = $package['destination']['country'];
						$dest_city    = $package['destination']['city'];
						$post_code    = $package['destination']['postcode'];
						$state        = $package['destination']['state'];
						$is_dosmestic = $dest_country == 'AE';
						$total_weight = MontWeightCalculator::set( $package['contents'] )->getTotalWeights();

						$markup = $is_dosmestic ? .1 : .05;

						$params = array(
							'ClientInfo'         => array(
								'AccountCountryCode' => 'AE',
								'AccountEntity'      => 'DXB',
								'AccountNumber'      => '51624',
								'AccountPin'         => '432432',
								'UserName'           => 'bilal@viii.ae',
								'Password'           => 'omarbilal@902',
								'Version'            => 'v1.0'
							),
							'OriginAddress'      => array(
								'City'        => 'Dubai',
								'CountryCode' => 'AE'
							),
							'DestinationAddress' => array(
								'City'        => $dest_city,
								'CountryCode' => $dest_country,
								'PostCode'    => $post_code,
								'State'       => $state,
							),
							'ShipmentDetails'    => array(
								'PaymentType'      => 'P',
								'ProductGroup'     => $dest_country == 'AE' ? 'DOM' : 'EXP',
								'ProductType'      => $dest_country == 'AE' ? 'CDS' : 'EDX',
								'ActualWeight'     => array( 'Value' => $total_weight, 'Unit' => 'KG' ),
								'ChargeableWeight' => array( 'Value' => $total_weight, 'Unit' => 'KG' ),
								'NumberOfPieces'   => 1,
								'CashOnDelivery'   => true
							)
						);

						$connected_to_soap = false;
						while ( ! $connected_to_soap )
						{
							try
							{
								$soapClient        = new SoapClient( plugin_dir_path( __FILE__ ) . 'aramex-rates-calculator-wsdl.wsdl', array( 'trace' => 1 ) );
								$results           = $soapClient->CalculateRate( $params );
								$connected_to_soap = true;
							}
							catch ( Exception $e )
							{
								$connected_to_soap = false;
								//persists connection
							}
						}

//						var_dump($results->Notifications->Notification);

						if ( $results->HasErrors )
						{
							$notification = $results->Notifications->Notification;

							$_SESSION['aramex_shipping_notification'] = $notification;

							return;
						}

						//clear error
//						unset( $_SESSION['aramex_shipping_notification'] );

						$aramex_shipping_amount = $results->TotalAmount->Value;
						$final_shipping_amount  = $aramex_shipping_amount + ( $aramex_shipping_amount * $markup );*/
						/*
												var_dump(plugin_dir_path( __FILE__ ) . 'aramex-rates-calculator-wsdl.wsdl');

												$shipping = new AramexShippingRates( $package );
												$shipping->calculate();

												/*$rate = array(
													'id'       => $this->id,
													'label'    => $this->title,
													'cost'     => $final_shipping_amount,
													'calc_tax' => 'per_item'
												);*/


						$shipping = new AramexShippingRates( $package );
						$shipping->calculate();

						if ( $shipping->errors() )
						{
							return;
						}

						$rate = array(
							'id'       => $this->id,
							'label'    => $this->title,
							'cost'     => $shipping->getFinalAmount(),
							'calc_tax' => 'per_item'
						);


						//Free Shipping if total weight is > 15KG
						if ( $shipping->getTotalWeight() >= 15 )
						{
							$rate['cost'] = 0;
						}

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




