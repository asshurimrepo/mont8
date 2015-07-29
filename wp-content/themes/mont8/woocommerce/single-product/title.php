<?php
	/**
	 * Single Product title
	 *
	 * @author        WooThemes
	 * @package    WooCommerce/Templates
	 * @version     1.6.4
	 */

	if ( ! defined( 'ABSPATH' ) )
	{
		exit; // Exit if accessed directly
	}


	global $product, $current_user;

	get_currentuserinfo();

	$author     = get_user_by( 'id', $product->post->post_author );
	$store_info = dokan_get_store_info( $author->ID );

	$store_url  = dokan_get_store_url( $author->ID );

	// var_dump($current_user);

?>

<div class="pull-right like-container" style="top:48px;">
	<?php get_template_part( 'dokan/btn', 'like' ); ?>
</div>

<div class="row product-title">
	<div class="col-md-2">
		<?= get_avatar( $author->ID, 128 ) ?>
	</div>
	<div class="col-md-7">
		<h1 itemprop="name" class="product_title"><?= $product->post->post_title ?>
			<small>By <a href="<?= $store_url ?>"><?= $store_info['store_name'] ?></a></small>
		</h1>
	</div>


	<div class="col-md-3">
		<?php
			// Check if logged in user is equal to this user
			if ( $current_user->ID != $author->ID )
			{
				echo do_shortcode( '[userpro template=card user=' . $author->user_login . ']' );
			}
		?>
	</div>


</div>
