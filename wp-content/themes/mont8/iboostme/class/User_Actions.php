<?php

	class User_Actions {

		protected $data;
		protected $user_meta;

		/**
		 * @var null
		 */
		private $user_id;

		public function __construct()
		{
			$this->user_id   = get_current_user_id();
			$this->user_meta = get_user_meta( $this->user_id );

			if ( isset( $_POST ) )
			{
				$this->data = $_POST;
			}
		}

		public static function listens()
		{
			$user_actions = new User_Actions();

			if ( isset( $_POST['add_gallery'] ) )
			{
				$user_actions->createGallery();
			}
		}

		public function createGallery()
		{
			if ( ! isset( $this->user_meta['_galleries'][0] ) )
			{
				$this->user_meta['_galleries'][0] = [ ];
			}


			exit;
		}


	}