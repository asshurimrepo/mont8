<div class="dokan-dashboard-wrap">
    <?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => 'product' ) ); ?>

    <div class="dokan-dashboard-content">

        <div class="dokan-new-product-area">
            <?php if ( Dokan_Template_Shortcodes::$errors ) { ?>
                <div class="dokan-alert dokan-alert-danger">
                    <a class="dokan-close" data-dismiss="alert">&times;</a>

                    <?php foreach ( Dokan_Template_Shortcodes::$errors as $error) { ?>

                        <strong><?php _e( 'Error!', 'dokan' ); ?></strong> <?php echo $error ?>.<br>

                    <?php } ?>
                </div>
            <?php } ?>

            <?php

            $can_sell = apply_filters( 'dokan_can_post', true );

            if ( $can_sell ) {

                if ( dokan_is_seller_enabled( get_current_user_id() ) ) { 
                    wp_enqueue_style( 'form-style', THEMEROOT . '/dokan/form-style.css', false, null );
                    wp_enqueue_script( 'dokan-product-js', THEMEROOT . '/dokan/dokan-product-js.js', false, null, true );
                ?>


                <form class="dokan-form-container" method="post">
                    <input type="hidden" name="post_content" value="">
                    <input type="hidden" name="price" value="0">
                    <div class="row product-edit-container dokan-clearfix row-1">
                        <div class="dokan-w12">
                            <h2>Upload your product</h2>
                            <div class="dokan-feat-image-upload">
                                <div class="instruction-inside">
                                    <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="0">
                                    <i class="fa fa-cloud-upload"></i>
                                    <a href="#" class="dokan-feat-image-btn dokan-btn"><?php _e( 'Upload Product Image', 'dokan' ); ?></a>
                                </div>

                                <div class="image-wrap dokan-hide">
                                    <a class="close dokan-remove-feat-image">&times;</a>
                                        <img src="" alt="" class="dokan-small-featured-image">
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row dokan-clearfix row-button dokan-hide">
                        <div class="dokan-w12">
                            <div class="btn btn-primary dokan-btn continue-button next-button">Continue to Description <i class="fa fa-angle-double-right"></i></div>
                        </div>
                    </div>
                    <div class="row product-edit-container dokan-another-container dokan-clearfix row-2 dokan-hide">
                        <div class="dokan-w5">
                            <div class="dokan-feat-image-upload-new">
                                <div class="image-wrap dokan-large-product-image-wrapper">
                                    
                                </div>
                            </div>
                        </div>
                        <div class="dokan-w6">
                            <div class="dokan-form-group">
                                <label class="label-title is-required"><?php esc_attr_e( 'Image title', 'dokan' ); ?></label>
                                <input class="dokan-form-control" name="post_title" id="post-title" type="text" placeholder="" value="<?php echo dokan_posted_input( 'post_title' ); ?>">
                            </div>

                            <div class="dokan-form-group">
                                <label class="label-title"><?php esc_attr_e( 'Brief description', 'dokan' ); ?></label>
                                <textarea name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder=""><?php echo dokan_posted_textarea( 'post_excerpt' ); ?></textarea>
                            </div>
                            
                            <?php if ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'single' ): ?>
                                <div class="dokan-form-group">

                                    <?php
                                    wp_dropdown_categories( array(
                                        'show_option_none' => __( '- Select a category -', 'dokan' ),
                                        'hierarchical'     => 1,
                                        'hide_empty'       => 0,
                                        'name'             => 'product_cat',
                                        'id'               => 'product_cat',
                                        'taxonomy'         => 'product_cat',
                                        'title_li'         => '',
                                        'class'            => 'product_cat dokan-form-control chosen',
                                        'exclude'          => '',
                                        'selected'         => Dokan_Template_Shortcodes::$product_cat,
                                    ) );
                                    ?>
                                </div>
                            <?php elseif ( dokan_get_option( 'product_category_style', 'dokan_selling', 'single' ) == 'multiple' ): ?>
                                <div class="dokan-form-group dokan-list-category-box">
                                    <h5><?php _e( 'Add to categories', 'dokan' );  ?> <small><?php _e( 'Choose 0 to 3 categories', 'dokan' );  ?></small></h5>
                                    <ul class="dokan-checkbox-cat">
                                        <?php
                                        include_once DOKAN_LIB_DIR.'/class.category-walker.php';
                                        wp_list_categories(array(

                                          'walker'       => new DokanCategoryWalker(),
                                          'name'         => 'product_cat',
                                          'title_li'     => '',
                                          'id'           => 'product_cat',
                                          'hide_empty'   => 0,
                                          'taxonomy'     => 'product_cat',
                                          'hierarchical' => 1,    
                                          'selected'     => array()
                                        ));
                                        ?>
                                    </ul>
                                </div>
                            <?php endif; ?>

                            <div class="dokan-form-group">

                                <?php
                                $drop_down_tags = wp_dropdown_categories( array(
                                    'show_option_none' => __( '', 'dokan' ),
                                    'hierarchical'     => 1,
                                    'hide_empty'       => 0,
                                    'name'             => 'product_tag[]',
                                    'id'               => 'product_tag',
                                    'taxonomy'         => 'product_tag',
                                    'title_li'         => '',
                                    'class'            => 'product_tags dokan-form-control chosen',
                                    'exclude'          => '',
                                    'selected'         => '',
                                    'echo'             => 0
                                ) );
                                ?> <label class="label-title"><?php esc_attr_e( 'Tags', 'dokan' ); ?> </label>
                                <?php echo str_replace( '<select', '<select data-placeholder="Select Tags" multiple="multiple" ', $drop_down_tags );
                                ?>
                            </div>

                            <div class="dokan-form-group">
                                <label class="label-title"><?php esc_attr_e( 'Location', 'dokan' ); ?></label>
                                <input class="dokan-form-control" name="location" id="location" type="text" placeholder="" value="<?php echo dokan_posted_input( 'location' ); ?>">
                            </div>

                            
                            <a href="#" class="show-product-arrt">Change products and pricing for this art piece</a>

                        </div>

                    </div>
                    
                    <div class="row product-edit-container dokan-clearfix row-3 dokan-hide">
                        <div class="dokan-w12">
                            <h3>Products and pricing</h3>
                            <p class="desc" style="width:100%;">
                                Here you're able to select which mediums you'd like your piece to be printed on, along with<br />
                                the percentage markup for each medium.<a href="#">Learn more about Products and Pricing.</a>
                            </p>
                            <p>
                                Markup percentage must be between <strong>0-300%</strong>
                            </p>
                            <p>&nbsp</p>
                                <?php 
                                $attribute_taxonomies = wc_get_attribute_taxonomies();
                                $i = 0;
                                foreach ($attribute_taxonomies as $taxonomies) {
                                    $taxonomy = wc_attribute_taxonomy_name( $taxonomies->attribute_name );
                                    $terms = get_terms( $taxonomy, 'orderby=name&hide_empty=0' );
                                    // $as = get_term_by('slug', 'art-print','pa_print' );
                                    // vd($terms,$as);
                                    // wp_delete_term( $as->term_id, 'pa_print');
                                    if($taxonomy == 'pa_print') {?>

                                        <table class="table dokan-table">
                                            <tr>
                                                <td width="20%"><?php echo $taxonomies->attribute_name; ?></td>
                                                <td width="60%"></td>
                                                <td width="20%"><?php echo $taxonomy == 'pa_print' ? 'Markup (%)' : 'in CM'; ?></td>
                                            </tr>
                                            <?php
                                            foreach ($terms as $term) { ?>
                                                
                                                <tr>
                                                    <td>
                                                        <!-- <img src="<?php echo get_stylesheet_directory_uri(); ?>/dokan/<?php echo $taxonomy == 'pa_print' ? $term->slug : 'size'; ?>.jpg" alt="" width="100%" > -->
                                                        <?php
                                                        $image          = '';
                                                        $thumbnail_id   = get_woocommerce_term_meta( $term->term_id, 'thumbnail_id', true );
                                                        if ($thumbnail_id) {
                                                            $image = wp_get_attachment_thumb_url( $thumbnail_id );
                                                        }
                                                        else {
                                                            $image          = wedd_placeholder_img_src();
                                                        }
                                                        ?>
                                                        <img src="<?php echo esc_url( $image ); ?>" alt="Thumbnail" width="50%" >
                                                    </td>
                                                    <td>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input name="<?php echo $taxonomy; ?>[term_id][<?php echo $term->term_id; ?>]" type="checkbox" value="<?php echo $term->name; ?>" checked> <?php echo $term->name; ?>
                                                        </label>
                                                    </div>
                                                    </td>
                                                    <td>
                                                        <input type="number" class="printnumber" value="30" min="0" max="300" step="1" name="<?php echo $taxonomy; ?>[pacent][<?php echo $term->term_id; ?>]">
                                                    </td>
                                                </tr>

                                            <?php
                                            } ?>
                                            <tr>
                                                <td width="20%">&nbsp;</td>
                                                <td width="60%">&nbsp;</td>
                                                <td width="20%">&nbsp;</td>
                                            </tr>
                                        </table>
                                    <?php } else {
                                        foreach ($terms as $term) {
                                            ?>
                                            <input name="<?php echo $taxonomy; ?>[term_id][<?php echo $term->term_id; ?>]" type="hidden" value="<?php echo $term->name; ?>">
                                            <?php
                                        }
                                    }?>
                                    <input type="hidden" name="attribute_names[]" value="<?php echo $taxonomy; ?>">
                                    <input type="hidden" name="attribute_is_taxonomy[]" value="1">
                                    <input type="hidden" name="attribute_position[]" value="<?php echo $i; ?>">
                                    <input type="hidden" name="attribute_visibility[]" value="1">
                                    <input type="hidden" name="attribute_variation[]" value="1">
                                    <?php
                                    $i++;
                                }
                                ?>
                        </div>
                    </div>
                    <div class="row product-edit-container dokan-another-container dokan-clearfix row-4 dokan-hide">
                        <div class="dokan-w12">
                            <div class="dokan-form-group">
                                <?php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ); ?>
                                <input type="submit" name="add_product" class="dokan-btn dokan-btn-danger dokan-btn-theme pull-right" value="<?php esc_attr_e( 'Upload Art', 'dokan' ); ?>"/>
                            </div>
                        </div>
                    </div>

                    <hr>

                    <div class="row product-edit-container dokan-clearfix row-4">
                        <div class="dokan-w12">
                            <a href="#">Have questions about uploading images?</a><br />
                            <a href="#">Curious about image formatting?</a><br />
                            <a href="#">Learn about our color management</a>
                        </div>
                    </div>

                </form>
                
                <?php } else { ?>

                    <?php dokan_seller_not_enabled_notice(); ?>

                <?php } ?>

            <?php } else { ?>

                <?php do_action( 'dokan_can_post_notice' ); ?>

            <?php } ?>
    </div> <!-- #primary .content-area -->
</div><!-- .dokan-dashboard-wrap -->