<?php

	class IB_Ajax {

		private $request;

		public function __construct( $request )
		{
			$this->request = $request;
		}

		public static function handle()
		{
			( new self( $_REQUEST ) )->handles();
		}

		private function handles()
		{
			if ( method_exists( $this, $this->request['action'] ) )
			{
				$this->{$this->request['action']}();
				exit;
			}
		}


		public function notify_user_liked_artwork()
		{

			$post         = get_post( $this->request['prod_id'] );
			$to_notify_id = $post->post_author;

			Notification::set()->user_liked_artwork( $to_notify_id, $post->post_title, get_permalink( $post->ID ) );
		}
	}