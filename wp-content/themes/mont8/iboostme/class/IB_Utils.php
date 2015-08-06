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
		public static function get_base_price( $product_id, $artwork_type = null )
		{
			$product = new WC_Product( $product_id );

			if ( ! $artwork_type )
			{
				$artwork_type = 'art_print';
			}

//			var_dump($product);

			$is_square = is_square( $product->get_image_id() );
			$is_owner  = $product->post->post_author == get_current_user_id();

			$markup['framed_print'] = $is_owner ? 0 : (int) get_post_meta( $product_id, "_framed_print_markup", true );
			$markup['art_print']    = $is_owner ? 0 : (int) get_post_meta( $product_id, "_art_print_markup", true );
			$markup['photo_print']  = $is_owner ? 0 : (int) get_post_meta( $product_id, "_photo_print_markup", true );
			$markup['canvas']       = $is_owner ? 0 : (int) get_post_meta( $product_id, "_canvas_markup", true );
			$markup['poster']       = $is_owner ? 0 : (int) get_post_meta( $product_id, "_poster_markup", true );

//			var_dump($markup);

			$base_prices = get_base_price( null, $is_square );

			$art_prices = array();

			foreach ( $markup as $key => $v )
			{
				$base_price = $base_prices->$key;
				$markup     = $base_price[0] * ( $v / 100 );

				$art_prices[ $key ] = $base_price[0] + $markup;
			}


			$final_base_price = min( $art_prices );

			if ( $artwork_type )
			{
				$final_base_price = $art_prices[ $artwork_type ];
			}

			$final_base_price *= get_current_currency( 'rate' );
//			$final_base_price = ceil( $final_base_price );
			$final_base_price = number_format( $final_base_price, 2 );

//			var_dump($final_base_price);

			$preview_price = get_woocommerce_currency_symbol() . $final_base_price;

			return $preview_price;
		}


		/**
		 * Generate 32 characters hash
		 *
		 * @return string
		 */
		public static function generate_hash()
		{
			return substr( str_shuffle( MD5( microtime() ) ), 0, 32 );
		}

	}