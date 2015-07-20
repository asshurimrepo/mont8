<?php
	if ( ! is_user_logged_in() )
	{
		return;
	}

	$user_id = get_current_user_id();
?>

<a href="<?= dokan_is_seller_enabled( $user_id ) ? dokan_get_navigation_url( 'new-product' ) : get_migration_to_seller_url() ?>"
   class="btn-upload"><?= __( 'Upload Art', 'dokan' ) ?></a>