<?php

	class Like_Artwork {

		protected $request;

		public function __construct()
		{
			$this->request = $_REQUEST;
		}

		public function init()
		{
			if ( ! is_ajax() )
			{
				return;
			}

			$this->like_an_artwork();

		}

		public function like_an_artwork()
		{
			if ( ! is_user_logged_in() )
			{
				echo $this->must_login();
				exit;
			}

			$likes    = (array) get_post_meta( $this->request['post_id'], 'likes', true );
			$new_like = get_current_user_id();

			if ( in_array( $new_like, $likes ) )
			{
				echo json_encode(
					[
						'type'    => 'error',
						'message' => 'Already Liked',
						'count'   => count( $likes ) - 1,
					] );
				exit;
			}

			$likes[] = $new_like;

			update_post_meta( $this->request['post_id'], 'likes', $likes );

			$post         = get_post( $this->request['post_id'] );
			$to_notify_id = $post->post_author;


			Notification::set()->user_liked_artwork( $to_notify_id, $post->post_title, get_permalink( $post->ID ) );


			echo json_encode(
				[
					'type'    => 'success',
					'message' => 'Liked',
					'count'   => count( $likes ) - 1,
				] );

			exit;
		}

		public function must_login()
		{
			wc_clear_notices();
			wc_add_notice( __( 'You Must Logged in to like an Artwork of your choice', 'dokan' ), 'error' );

			return json_encode(
				[
					'redirect' => get_my_account_url()
				]
			);

		}
	}
