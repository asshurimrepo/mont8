<?php if ( isset( $message ) ): ?>

	<div class="dokan-alert dokan-alert-success">
		<a class="dokan-close" data-dismiss="alert">&times;</a>

		<strong><?php _e( 'Success!', 'dokan' ); ?></strong> <?php echo $message ?>.<br>

	</div>

<?php endif; ?>
