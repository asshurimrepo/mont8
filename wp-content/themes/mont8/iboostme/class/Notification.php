<?php

	use Carbon\Carbon;

	class Notification {

		protected $key = '_notifications_item';

		public function __construct()
		{

		}

		public static function set()
		{
			return new self();
		}


		public static function get( $id = null )
		{
			if ( ! $id )
			{
				$id = get_current_user_id();
			}

			return ( new Notification() )->getNotifications( $id );
		}


		public function follow( $from, $to )
		{
			$notification_items = (array) get_user_meta( $to, $this->key, true );

			$followed = get_user_by( 'id', $to );
			$follower = get_user_by( 'id', $from );

			$follower_store_url = dokan_get_store_url( $from );

			$notification_items[] = [
				'type'    => 'follow',
				'icon'    => 'hand-o-right',
				'message' => "<a href='{$follower_store_url}'>{$follower->data->display_name} </a>  Followed You",
				'date'    => Carbon::now()
			];

			update_user_meta( $to, $this->key, $notification_items );
		}


		public function user_liked_artwork( $to_notify_id, $artwork_name, $artwork_permalink )
		{
			if ( ! is_user_logged_in() )
			{
				return null;
			}

			$notification_items = (array) get_user_meta( $to_notify_id, $this->key, true );

			$liker          = get_user_by( 'id', get_current_user_id() );
			$to_notify_user = get_user_by( 'id', $to_notify_id );
			$liker_store    = dokan_get_store_url( get_current_user_id() );

			$notification_items[] = [
				'type'    => 'like',
				'icon'    => 'thumbs-o-up',
				'message' => "<a href='{$liker_store}'>{$liker->data->display_name} </a>  Likes your Artwork <a href='{$artwork_permalink}'>{$artwork_name}</a>",
				'date'    => Carbon::now()
			];

			update_user_meta( $to_notify_id, $this->key, $notification_items );

			/*Send an Email*/
			$this->emailUserLikedArtwork( $artwork_name, $liker, $to_notify_user );
		}


		public function getNotifications( $id )
		{
			$notifications = (array) get_user_meta( $id, $this->key, true );

			$notifications = array_reverse( $notifications );

			return array_filter( $notifications, function ( $notif )
			{
				return $notif;
			} );
		}

		/**
		 * @param $artwork_name
		 * @param $liker
		 * @param $to_notify_user
		 */
		private function emailUserLikedArtwork( $artwork_name, $liker, $to_notify_user )
		{
			$subject      = "{$liker->data->display_name} has liked your {$artwork_name}";

			$message      = nl2br(
				"Hi {$to_notify_user->data->display_name},

				All eyes are on you because {$liker->data->display_name} just hearted your {$artwork_name}!"
			);

			$mail_message = WC()->mailer()->wrap_message( $subject, $message );

			WC()->mailer()->send( $to_notify_user->user_email, $subject, $mail_message );
		}

	}
