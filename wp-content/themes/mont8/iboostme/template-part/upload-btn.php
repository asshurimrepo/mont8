<?php
	if ( ! is_user_logged_in() )
	{
		return;
	}
?>

<a href="<?= dokan_is_user_seller( $user_id ) ? dokan_get_navigation_url( 'new-product' ) : get_migration_to_seller_url() ?>"
   class="btn-upload"><?= __( 'Upload Art', 'dokan' ) ?></a>