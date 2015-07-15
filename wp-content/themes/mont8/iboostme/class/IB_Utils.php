<?php

	class IB_Utils {

		/**
		 * Convert WP_Post to WC_Product
		 *
		 * @param array $array
		 *
		 * @return array
		 */
		public static function post_to_product( array $array )
		{
			return array_map( function ( $wc_post )
			{
				$wc_post = new WC_Product( $wc_post->ID );

				return $wc_post;

			}, $array );
		}

		/**
		 * Get the lowest base price of the artwork
		 *
		 * @param $product_id
		 *
		 * @param string $artwork_type
		 *
		 * @return string
		 */
		public static function get_base_price( $product_id, $artwork_type = 'poster' )
		{

			$poster_markup    = get_post_meta( $product_id, "_{$artwork_type}_markup", true );
			$base_price       = get_base_price( 'poster' );
			$markup_price     = $base_price[0] * ( $poster_markup / 100 );
			$final_base_price = number_format( $base_price[0] + $markup_price, 2 );
			$final_base_price *= get_current_currency( 'rate' );
			$preview_price = get_woocommerce_currency_symbol() . $final_base_price;

			return $preview_price;
		}

	}