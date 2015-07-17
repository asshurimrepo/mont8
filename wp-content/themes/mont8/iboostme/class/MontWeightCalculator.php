<?php

	/**
	 * Class MontWeightCalculator
	 */
	class MontWeightCalculator {

		/**
		 * @var string
		 */
		public static $unit = 'KG';
		/**
		 * @var array
		 */
		private $cart_items;


		/**
		 * @var array
		 */
		private $weight_data = [

			'Fine Art Print'        => [
				'A5'          => '.5',
				'A4'          => '.5',
				'30cm x 30cm' => '.5',
				'A3'          => '.5',
				'40cm x 40cm' => '.5',
				'A2'          => '.5',
				'50cm x 50cm' => '.5',
				'60cm x 60cm' => '.5',
				'A1'          => '.5',
			],
			'Framed Fine Art Print' => [
				'A5'          => '.5',
				'A4'          => '1',
				'30cm x 30cm' => '1.5',
				'A3'          => '1.5',
				'40cm x 40cm' => '2',
				'A2'          => '2',
				'50cm x 50cm' => '2',
				'60cm x 60cm' => '2.5',
				'A1'          => '3',
			],
			'Photo Print'           => [
				'A5'          => '.5',
				'A4'          => '.5',
				'30cm x 30cm' => '.5',
				'A3'          => '.5',
				'40cm x 40cm' => '.5',
				'A2'          => '.5',
				'50cm x 50cm' => '.5',
				'60cm x 60cm' => '.5',
				'A1'          => '.5',
			],
			'Framed Photo Print'    => [
				'A5'          => '.5',
				'A4'          => '1',
				'30cm x 30cm' => '1.5',
				'A3'          => '1.5',
				'40cm x 40cm' => '2',
				'A2'          => '2',
				'50cm x 50cm' => '2',
				'60cm x 60cm' => '2.5',
				'A1'          => '3',
			],
			'Canvas'                => [
				'A5'          => null,
				'A4'          => null,
				'30cm x 30cm' => '1.5',
				'A3'          => '1.5',
				'40cm x 40cm' => '2',
				'A2'          => '2',
				'50cm x 50cm' => '2',
				'60cm x 60cm' => '2.5',
				'A1'          => '3',
			],
			'Framed Canvas'         => [
				'A5'          => null,
				'A4'          => null,
				'30cm x 30cm' => '3',
				'A3'          => '3',
				'40cm x 40cm' => '4',
				'A2'          => '4',
				'50cm x 50cm' => '4',
				'60cm x 60cm' => '5',
				'A1'          => '6',
			],
			'Poster'                => [
				'A5'          => null,
				'A4'          => null,
				'30cm x 30cm' => null,
				'A3'          => null,
				'40cm x 40cm' => null,
				'A2'          => '.5',
				'50cm x 50cm' => null,
				'60cm x 60cm' => null,
				'A1'          => '.5',
			]


		];

		/**
		 * @param array $cart_items
		 */
		public function __construct( $cart_items = [ ] )
		{

			$this->cart_items = $cart_items;
		}

		/**
		 * @param $cart_items
		 *
		 * @return MontWeightCalculator
		 */
		public static function set( $cart_items )
		{
			return new self( $cart_items );
		}

		/**
		 * @param $ref|size
		 * @param null $size
		 * @param null $quantity
		 *
		 * @return string
		 */
		public static function getWeightBySize( $ref, $size = null, $quantity = null )
		{
			$item['quantity']  = $quantity;
			$item['tmcartepo'] = [
				[
					'section_label' => 'Artwork Style',
					'value'         => $ref
				],
				[
					'section_label' => 'Artwork size',
					'value'         => $size
				]
			];


			if ( isset( $ref['tmcartepo'] ) )
			{
				$item = $ref;
			}

			return ( new self )->getItemWeight( $item ) . self::$unit;
		}

		/**
		 * @return int|mixed
		 */
		public function getTotalWeights()
		{
			$total_weight = 0;

			foreach ( $this->cart_items as $item )
			{
				$total_weight += $this->getItemWeight( $item );
			}

			return $total_weight;
		}

		/**
		 * @param $item
		 *
		 * @return mixed
		 */
		public function getItemWeight( $item )
		{
			$is_framed = false;
			$style     = null;
			$size      = null;

//			var_dump($item['tmcartepo']);


			foreach ( $item['tmcartepo'] as $options )
			{
				switch ( $options['section_label'] )
				{
					case 'Artwork Style':
						$style = $options['value'];
						break;
					case 'Artwork size':
						$size = $this->getItemKey( $options['value'] );
						break;
					case 'Frame this print':
						$is_framed = true;
						break;

				}
			}

//			var_dump($style.$size);

			if ( $is_framed )
			{
				return $this->weight_data["Framed {$style}"][ $size ] * $item['quantity'];
			}

			return $this->weight_data[ $style ][ $size ] * $item['quantity'];

		}

		/**
		 * @param $size
		 *
		 * @return mixed
		 */
		public function getItemKey( $size )
		{

			//If Square artwork
			if ( strpos( $size, '0cm' ) !== false )
			{
				return $size;
			}

			$value = explode( ' ', $size );

			return $value[0];
		}
	}