<?php

	class AramexShippingRates {

		/**
		 * @var
		 */
		protected $dest_country;
		/**
		 * @var
		 */
		protected $post_code;
		/**
		 * @var
		 */
		protected $state;
		/**
		 * @var int|mixed
		 */
		protected $total_weight;
		/**
		 * @var bool
		 */
		protected $is_dosmestic;
		/**
		 * @var
		 */
		protected $dest_city;
		/**
		 * @var
		 */
		protected $results;
		/**
		 * @var
		 */
		private $package;
		/**
		 * @var string
		 */
		private $wsdl;

		private $range_weight = 10;

		/**
		 * @param $package
		 * @param string $wsdl
		 */
		public function __construct( $package, $wsdl = null )
		{
			$this->dest_country = $package['destination']['country'];
			$this->dest_city    = $package['destination']['city'];
			$this->post_code    = $package['destination']['postcode'];
			$this->state        = $package['destination']['state'];
			$this->is_dosmestic = $this->dest_country == 'AE';
			$this->total_weight = MontWeightCalculator::set( $package['contents'] )->getTotalWeights();
			$this->package      = $package;
			$this->wsdl         = $wsdl;

			$this->calculate();
		}


		/**
		 * @return array
		 */
		protected function getParams()
		{
			return array(
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
					'City'        => $this->dest_city,
					'CountryCode' => $this->dest_country,
					'PostCode'    => $this->post_code,
					'State'       => $this->state,
				),
				'ShipmentDetails'    => array(
					'PaymentType'      => 'P',
					'ProductGroup'     => $this->dest_country == 'AE' ? 'DOM' : 'EXP',
					'ProductType'      => $this->dest_country == 'AE' ? 'CDS' : 'EDX',
					'ActualWeight'     => array( 'Value' => $this->total_weight, 'Unit' => 'KG' ),
					'ChargeableWeight' => array( 'Value' => $this->total_weight, 'Unit' => 'KG' ),
					'NumberOfPieces'   => 1,
					'CashOnDelivery'   => true
				)
			);
		}

		/**
		 * @return float
		 */
		protected function getMarkup()
		{
			//No markup if total weight is >= 10KG -> default range weight
			if ( $this->getTotalWeight() >= $this->range_weight )
			{
				return 0;
			}

			//if total weights <= 5kg -> returns domestic 10% , international 5%
			if ( $this->getTotalWeight() <= 5 )
			{
				return $this->is_dosmestic ? .1 : .05;
			}

			//if total weights > 5kg -> returns domestic 5% , international 5%
			return $this->is_dosmestic ? .05 : .05;

		}

		/**
		 * @return $this
		 * @throws Exception
		 */
		public function calculate()
		{
			$this->results     = [ ];
			$connected_to_soap = false;
			$max_tries         = 50;
			$tries             = 0;

//			var_dump($this->getWsdl());

			//persists connection
			while ( ! $connected_to_soap && $tries <= $max_tries )
			{
				try
				{
					$soapClient        = new SoapClient( $this->getWsdl(), array( 'trace' => 1 ) );
					$this->results     = $soapClient->CalculateRate( $this->getParams() );
					$connected_to_soap = true;
				}
				catch ( Exception $e )
				{
					$tries += 1;
					$connected_to_soap = false;
				}
			}

			if ( $tries > $max_tries )
			{
				throw new Exception( "Can't Connect to Aramex Rates API Server" );
			}

			return $this;

		}

		/**
		 * @return null
		 */
		public function getAmount()
		{
			if ( $this->errors() )
			{
				return null;
			}

			return $this->results->TotalAmount->Value;
		}

		/**
		 * @return null
		 */
		public function getFinalAmount()
		{
			if ( $this->errors() )
			{
				return null;
			}

			return $this->getAmount() + ( $this->getAmount() * $this->getMarkup() );
		}


		/**
		 * @return bool
		 */
		public function errors()
		{

			if ( $this->results->HasErrors )
			{
				return $this->results->Notifications->Notification;
			}

			return false;

		}

		/**
		 * @return int|mixed
		 */
		public function getTotalWeight()
		{
			return $this->total_weight;
		}

		/**
		 * @return string
		 */
		public function getWsdl()
		{
			return ABSPATH . 'wp-content/plugins/woocommerce-amarex-shipping/' . 'aramex-rates-calculator-wsdl.wsdl';
		}

		public function __toString()
		{
			return '';
		}

	}