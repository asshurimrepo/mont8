<div class="dokan-post-status dokan-toggle-sidebar">
                                        <label for="post_status"><?php _e( 'Product Status:', 'dokan' ); ?></label>

                                        <?php $pending_class = $post->post_status == 'pending' ? '  dokan-label dokan-label-warning': ''; ?>
                                        <span class="dokan-toggle-selected-display<?php echo $pending_class; ?>"><?php echo dokan_get_post_status( $post->post_status ); ?></span>

                                        <?php if ( $post->post_status != 'pending' ) { ?>
                                            <a class="dokan-toggle-edit dokan-label dokan-label-success" href="#"><?php _e( 'Edit', 'dokan' ); ?></a>

                                            <div class="dokan-toggle-select-container dokan-hide">

                                                <?php $post_statuses = apply_filters( 'dokan_post_status', array(
                                                    'publish' => __( 'Online', 'dokan' ),
                                                    'draft'   => __( 'Draft', 'dokan' )
                                                ), $post ); ?>

                                                <select id="post_status" class="dokan-toggle-select" name="post_status">
                                                    <?php foreach ($post_statuses as $status => $label) { ?>
                                                        <option value="<?php echo $status; ?>"<?php selected( $post->post_status, $status ); ?>><?php echo $label; ?></option>
                                                    <?php } ?>
                                                </select>

                                                <a class="dokan-toggle-save dokan-btn dokan-btn-default dokan-btn-sm" href="#"><?php _e( 'OK', 'dokan' ); ?></a>
                                                <a class="dokan-toggle-cacnel" href="#"><?php _e( 'Cancel', 'dokan' ); ?></a>
                                            </div> <!-- #dokan-toggle-select -->
                                        <?php } ?>
                                    </div>