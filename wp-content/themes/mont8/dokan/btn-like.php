<?php
	$product = Share::getData();
	$likes   = (array) get_post_meta( $product->id, 'likes', true );
	$count   = count( $likes ) - 1 ?: null;
	$nonce   = wp_create_nonce( "my_user_vote_nonce" );
	$link    = admin_url( 'admin-ajax.php?action=like_artwork&post_id=' . $product->id . '&nonce=' . $nonce );
	$liked   = in_array( get_current_user_id(), $likes );
	$like_text = $liked ? __( 'Liked', 'dokan' ) : __( 'Like this Artwork', 'dokan' );

	if ( ! is_user_logged_in() )
	{
		$liked     = false;
		$like_text = __( 'Like this Artwork', 'dokan' );
	}
?>

<button data-nounce="<?= $nonce ?>" data-ajax="<?= $link ?>" type="button" title="<?= $like_text ?>"
        class="tooltips button--like button_small <?= $liked ? 'active' : '' ?>">
	<i class="fa fa-heart"></i> <span class="like-count"><?= $count ?></span>
</button>