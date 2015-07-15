<?php


	class ProductMarkup {


		/**
		 * @var int
		 */
		public $canvas_markup;


		/**
		 * @var int
		 */
		public $framed_print_markup;


		/**
		 * @var int
		 */
		public $photo_print_markup;


		public $poster_markup;
		/**
		 * @var int
		 */
		public $art_print_markup;
		public $post_meta;

		/**
		 * @param int $_framed_print_markup
		 * @param int $_art_print_markup
		 * @param int $_photo_print_markup
		 * @param int $_canvas_markup
		 * @param int $_poster_markup
		 * @param null $post_meta
		 */
		public function __construct( $_framed_print_markup = 0, $_art_print_markup = 0, $_photo_print_markup = 0, $_canvas_markup = 0, $_poster_markup = 0, $post_meta = null )
		{

			$this->framed_print_markup = $_framed_print_markup;
			$this->art_print_markup    = $_art_print_markup;
			$this->photo_print_markup  = $_photo_print_markup;
			$this->canvas_markup       = $_canvas_markup;
			$this->poster_markup       = $_poster_markup;
			$this->post_meta           = $post_meta;
		}

		/**
		 * @return ProductMarkup
		 */
		public static function get()
		{
			global $product;

			$the_slug = $product;

			$args = array(
				'name'        => $the_slug,
				'post_type'   => 'product',
				'post_status' => 'publish',
				'numberposts' => 1
			);

			$post      = get_posts( $args );
			$post_meta = get_post_meta( $post[0]->ID );

			return new self(
				$post_meta['_framed_print_markup'][0],
				$post_meta['_art_print_markup'][0],
				$post_meta['_photo_print_markup'][0],
				$post_meta['_canvas_markup'][0],
				$post_meta['_poster_markup'][0],
				$post
			);
		}

		/**
		 * @param $key
		 *
		 * @return mixed
		 */
		public function getPostMeta( $key )
		{
			return $this->post_meta[0]->{$key};
		}

	}

	/*
	 * [markup]framed_print_markup[/markup]
	 * [markup]art_print_markup[/markup]
	 * [markup]photo_print_markup[/markup]
	 * [markup]canvas_markup[/markup]
	 * [markup]poster_markup[/markup]
	 * */

	function markup( $atts, $content = null )
	{

		$markups = ProductMarkup::get();

		//IF Logged in user owned this
		if ( get_current_user_id() == $markups->getPostMeta( 'post_author' ) )
		{
			return 0;
		}


//		var_dump($markups);


		return (double) $markups->{$content};
	}

	add_shortcode( 'markup', 'markup' );
