<?php

	class IB_User {

		/**
		 * Returns true if published product is > 0
		 *
		 * @return bool
		 */
		public function has_artwork()
		{
			$count_posts = wp_count_posts( 'product' );

			return $count_posts->publish > 0;
		}


		public function send_customer_activation_email( $user_id )
		{
			$user = get_user_by( 'id', $user_id );
			$key  = get_user_meta( $user->ID, 'account_verification_key', true );

			$subject = "You're Awesome";

			$activation_link = site_url() . "/?action=activate_customer_account&key={$key}";

			$message = nl2br(
				"Heyheyhey {$user->data->display_name}! Welcome to <b>Mont8</b>, the community and marketplace for artists of the creative nation who want to put a wide smile on your face through art products. Artist or Art lover this is your one stop destination for all of your artsywants and needs.

				You deserve a massive round of applause for joining Mont8 but more importantly, for being an agent of change for spreading and empowering art and artists in the Middle East.

				You’re just one small step away, <a href=\"{$activation_link}\">confirm your email address</a> and go back explore the gems we have ready for you!"
			);

			$mail_message = WC()->mailer()->wrap_message( $subject, $message );

			WC()->mailer()->send( $user->data->user_email, $subject, $mail_message );

		}


	}