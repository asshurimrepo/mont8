<?php

	$response       = User_Actions::listens();
	$notif_settings = $featured_products = get_the_author_meta( '_notifications', get_current_user_id() );

	$notif_types = [

		'comment' => 'When a user comments in your artwork',
		'follow'  => 'When a user followed you',
		'order'   => 'When a user ordered your artwork',

	];

//	var_dump( $notif_settings );

	iboost_include( 'iboostme/template-part/alerts', $response );
?>

<div class="col-md-10">
	<form method="post">

		<input type="hidden" name="update_notification">

		<?php foreach ( $notif_types as $type => $display_text ): ?>
			<div class="checkbox">
				<label>
					<input type="checkbox" <?= ! isset( $notif_settings[ $type ] ) ?: 'checked' ?>
					       name="_notifications[<?= $type ?>]" value="1"> <?= $display_text ?>
				</label>
			</div>
		<?php endforeach; ?>


		<button type="submit" class="dokan-btn dokan-btn-theme dokan-right">Save</button>
	</form>
</div>