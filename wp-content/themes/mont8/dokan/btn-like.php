<?php
	$product = Share::getData();
	$likes   = (array) get_post_meta( $product->id, 'likes', true );
	$count   = count( $likes ) > 1 ?: null;
	$nonce   = wp_create_nonce( "my_user_vote_nonce" );
	$link    = admin_url( 'admin-ajax.php?action=like_artwork&post_id=' . $product->id . '&nonce=' . $nonce );
	$liked   = in_array( get_current_user_id(), $likes );
?>

<a href="#!" data-nounce="<?= $nonce ?>" data-ajax="<?= $link ?>"
   class="like-btn tooltips <?= $liked ? 'active' : '' ?>" title="Like this Artwork">
	<i class="fa fa-gratipay"></i>
</a>

<span class="like-count"><?= $count ?></span>