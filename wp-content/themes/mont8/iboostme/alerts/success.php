<?php if( !isset($_success_message) ) $_success_message = null; ?>

<div class="dokan-message">
    <button type="button" class="dokan-close" data-dismiss="alert">×</button>
    <strong><?php _e( 'Success!', 'dokan' ); ?></strong> <?php _e( $_success_message, 'dokan' ); ?>
</div>