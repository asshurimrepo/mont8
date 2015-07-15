<?php

	class User_Actions {

		/**
		 * @var
		 */
		protected $data;
		/**
		 * @var mixed
		 */
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

		/**
		 *
		 */
		public static function listens()
		{
			$user_actions = new User_Actions();

			if ( isset( $_POST['set_featured_products'] ) )
			{
				return $user_actions->setFeaturedProducts();
			}


			if ( isset( $_POST['update_notification'] ) )
			{
				return $user_actions->updateNotification();
			}

			if ( isset( $_POST['save_account_details'] ) )
			{
				var_dump( $_POST );
			}

			return [ ];
		}

		/**
		 *
		 */
		public function createGallery()
		{
			if ( ! isset( $this->user_meta['_galleries'][0] ) )
			{
				$this->user_meta['_galleries'][0] = [ ];
			}


			exit;
		}

		private function setFeaturedProducts()
		{
			update_user_meta( $this->user_id, 'featured_products', $this->data['items'] );

			return [ 'message' => 'Featured Products Successfully Updated', ];
		}

		/**
		 *Update Notification settings of the user
		 */
		private function updateNotification()
		{
			$valid         = [ 'comment', 'follow', 'order' ];
			$notifications = [ ];

			foreach ( $this->data['_notifications'] as $key => $notif )
			{
				if ( in_array( $key, $valid ) )
				{
					$notifications[ $key ] = $notif;
				}
			}

			update_user_meta( $this->user_id, '_notifications', $notifications );

			return [ 'message' => 'Notification Settings Successfully Updated', ];
		}


	}