<?php
	/**
	 * Customer new account email
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates/Emails
	 * @version     1.6.4
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}

?>

<?php do_action( 'woocommerce_email_header', $email_heading ); ?>


	Heyheyhey <?= esc_html( $user_login ) ?>! Welcome to Mont8, the community and marketplace for artists of the creative nation who want to put a wide smile on your face through art products. Artist or Art lover this is your one-stop​ destination for all of your artsy wants and needs.
	<br/><br/>
	You deserve a massive round of applause for joining Mont8 but more importantly, for being an agent of change for spreading and empowering art and artists in the Middle East.
	<br/><br/>
	You’re just one small step away, confirm your email address if you want to start selling! We can do this right away. If you already completed this step, go and explore the gems we have ready for you!

<?php do_action( 'woocommerce_email_footer' ); ?>