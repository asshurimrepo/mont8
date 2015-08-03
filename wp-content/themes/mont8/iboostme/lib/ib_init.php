<?php

	/*handles any logic for Seller Class IB_User*/
	$ib_user = new IB_User();


	/*Hide some menus when the seller has no product yet*/
	add_filter( 'dokan_get_dashboard_nav', 'hide_some_seller_nav' );

	function hide_some_seller_nav( $urls )
	{
		global $ib_user;

		if ( $ib_user->has_artwork() )
		{
			return $urls;
		}

		unset( $urls['pricing'] );

		return $urls;
	}