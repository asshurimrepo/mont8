<?php

	use Carbon\Carbon;

	$response       = User_Actions::listens();
	$notif_settings = $featured_products = get_the_author_meta( '_notifications', get_current_user_id() );

	$notifications = Notification::get();

	$notif_types = [

		'comment' => 'When a user comments on your artwork',
		'follow'  => 'When a user follows you',
		'order'   => 'When a user orders one of your artwork',

	];

	//	var_dump( $notif_settings );

	iboost_include( 'iboostme/template-part/alerts', $response );
?>

<div class="col-md-12">
	<table class="table table-striped" style="background: #FFF;">
		<?php foreach ( $notifications as $notif ): ?>
			<tr>
				<td>
					<i class="fa fa-<?= $notif['icon'] ?>"></i>
					<?= $notif['message'] ?>
				</td>
				<td>
					<i class="fa fa-clock-o"></i> <?= Carbon::parse( $notif['date'] )->diffForHumans() ?>
				</td>
			</tr>
		<?php endforeach; ?>
	</table>

	<?php if ( ! count( $notifications ) ): ?>
		<div class="alert alert-warning">
			<i class="fa fa-info"></i> You don't have any notifications yet.
		</div>
	<?php endif; ?>

</div>

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