<?php

	class MontBasePrice {

		protected $base_prices = null;

		public function __construct()
		{
			$frontpage_id = get_option( 'page_on_front' );
			$this->base_prices = get_field( 'artwork_types', $frontpage_id );

		}

		/**
		 * @return mixed
		 */
		public function getAllBasePrices()
		{
			return $this->base_prices;
		}


		public function getBasePrice( $type, $board_type, $size )
		{

			foreach ( $this->base_prices as $base_price )
			{
				if ( $type != $base_price['label'] )
				{
					continue;
				}

				foreach ( $base_price['variations'] as $variation )
				{
					if ( $variation['label'] != $board_type )
					{
						continue;
					}

					return (double) $variation[ $size ];
				}
			}

			return null;
		}


	}


	$mont_base_price = new MontBasePrice();

	/*
	 * Get base price shortcode
	 *
	 *
	 * [base_price type="Art Print" frame="Normal" size="a5"]
	 * [base_price type="Art Print" frame="Without Matt Board" size="a5"]
	 * [base_price type="Art Print" frame="With Matt Board" size="a5"]
	 *
	 * [base_price type="Art Print" frame="Normal" size="30cm_x_30cm"]
	 * [base_price type="Art Print" frame="Without Matt Board" size="30cm_x_30cm"]
	 * [base_price type="Art Print" frame="With Matt Board" size="30cm_x_30cm"]
	 *
	 * [base_price type="Photo Print" frame="Normal" size="a5"]
	 * [base_price type="Photo Print" frame="Without Matt Board" size="a5"]
	 * [base_price type="Photo Print" frame="With Matt Board" size="a5"]
	 *
	 *
	 * */

	add_shortcode( 'base_price', 'get_mont8_base_price' );

	function get_mont8_base_price( $atts, $content = null )
	{
		$a = shortcode_atts( array(
			'type'  => '',
			'frame' => '',
			'size'  => '',
		), $atts );

		$mont_base_price = new MontBasePrice();

		/*if($_POST){
			var_dump($_POST);
			var_dump($mont_base_price->getBasePrice( $a['type'], $a['frame'], $a['size'] ));
			exit;
		}*/

		return (double) $mont_base_price->getBasePrice( $a['type'], $a['frame'], $a['size'] );
	}
