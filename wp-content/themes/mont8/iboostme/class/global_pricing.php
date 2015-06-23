<?php

	class GlobalPricing {

		protected $data;
		protected $user_id;
		protected $user_meta;
		protected $success_message = 'The default markup rates have been set for your products. All new uploads will default to the values you chose.';

		public function __construct( $user_id, $data = [ ] )
		{
			$this->data      = $data;
			$this->user_id   = $user_id;
			$this->user_meta = get_user_meta( $user_id );
		}

		public static function listens()
		{

			if ( isset( $_POST['update_pricing'] ) )
			{
				( new GlobalPricing( get_current_user_id(), $_POST ) )->updateMarkups();
			}

		}


		public function get_markup( $key )
		{
			return $this->user_meta["_{$key}_markup"][0];
		}


		public function updateMarkups()
		{
			update_user_meta( $this->user_id, '_framed_print_markup', $this->data['_framed_print_markup'] );
			update_user_meta( $this->user_id, '_art_print_markup', $this->data['_art_print_markup'] );
			update_user_meta( $this->user_id, '_photo_print_markup', $this->data['_photo_print_markup'] );
			update_user_meta( $this->user_id, '_canvas_markup', $this->data['_canvas_markup'] );
			update_user_meta( $this->user_id, '_poster_markup', $this->data['_poster_markup'] );

			iboost_include( 'iboostme/alerts/success', array( '_success_message' => $this->success_message ) );
		}


	}