<?php

	class IB_User {

		/**
		 * @var null
		 */
		private $user_id;

		public function __construct( $user_id = null )
		{

			$this->user_id = $user_id ?: get_current_user_id();
		}

		/**
		 * Returns true if published product is > 0
		 *
		 * @return bool
		 */
		public function has_artwork()
		{
			$count_posts = count_user_posts( $this->user_id, 'product' );

			return $count_posts > 0;
		}


		/**
		 * Send Email Confirmation to verify Account
		 *
		 * @param $user_id
		 */
		public function send_customer_activation_email( $user_id )
		{
			$user = get_userdata( $user_id );
			$key  = get_user_meta( $user->ID, 'account_verification_key', true );

			$subject = "You're Awesome";

			$activation_link = site_url() . "/?action=activate_customer_account&key={$key}";

			$message = nl2br(
				"Heyheyhey {$user->first_name} {$user->last_name}! Welcome to Mont8, the community and marketplace for artists of the creative nation who want to put a wide smile on your face through art products. Artist or Art lover this is your one stop destination for all of your artsy wants and needs.

				You deserve a massive round of applause for joining Mont8 but more importantly, for being an agent of change for spreading and empowering art and artists in the Middle East.

				You’re just one small step away, <a href=\"{$activation_link}\">confirm your email address</a> and go back explore the gems we have ready for you!

				Not only that, you can start selling! We can do this right away. Request to be a seller from your dashboard and start uploading your Art."
			);

			add_filter( 'woocommerce_email_from_address', 'from_halwallah_address' );

			$this->sendMail( $user, $subject, $message );

		}

		/**
		 * Send Email Confirmation to enable selling
		 *
		 * @param $user_id
		 */
		public function send_seller_activation_email( $user_id )
		{
			$user = get_userdata( $user_id );
			$key  = get_user_meta( $user->ID, 'seller_verification_key', true );

			$subject = "You're Awesome";

			$activation_link = site_url() . "/?action=activate_seller_account&key={$key}";

			$message = "Heyheyhey {$user->first_name} {$user->last_name}! Welcome to Mont8, the community and marketplace for artists of the creative nation who want to put a wide smile on your face through art products. Artist or Art lover this is your one stop destination for all of your artsy wants and needs.

				You deserve a massive round of applause for joining Mont8 but more importantly, for being an agent of change for spreading and empowering art and artists in the Middle East.

				You’re just one small step away, <a href=\"{$activation_link}\">confirm your email address</a> and go back explore the gems we have ready for you!

				Not only that, you can start selling! We can do this right away. Request to be a seller from your dashboard and start uploading your Art.";


			add_filter( 'woocommerce_email_from_address', 'from_halwallah_address' );

			$this->sendMail( $user, $subject, $message );
		}


		public function send_seller_product_approval_email( $user_id, $product )
		{

			$user = get_userdata( $user_id );

			$subject = "Mabrook Habeebi!";

			$message = "Marhaba {$user->first_name} {$user->last_name}!

				Congratulations, your artwork has been approved to be sold nationwide, get busy showing it around and show your fans how owning your art is now easier than ever.

				All the best,
				The Mont8 Family";


			add_filter( 'woocommerce_email_from_address', 'from_habebe_address' );


			$this->sendMail( $user, $subject, $message );
		}


		/**
		 * Handles Custom Auto Reply Mail
		 *
		 * @param $user
		 * @param $subject
		 * @param $message
		 */
		public function sendMail( $user, $subject, $message )
		{

			$bcc = apply_filters( 'woocommerce_email_from_address', 'developer@cjnetsolutions.com' );

			$headers = "Content-Type: text/html\r\n";
			$headers .= "Bcc: $bcc\r\n";

			$message      = nl2br( $message );
			$mail_message = WC()->mailer()->wrap_message( $subject, $message );
			WC()->mailer()->send( $user->data->user_email, $subject, $mail_message, $headers );
		}


	}