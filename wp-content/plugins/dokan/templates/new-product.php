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

                if ( dokan_is_seller_enabled( get_current_user_id() ) ) { ?>

                <form id="dokanForm" class="form-group dokan-form-container" method="post">
                    <input type="hidden" name="post_content" value="">
                    <input type="hidden" name="price" value="0">
                    
                    <?php
                    $attribute_taxonomies = wc_get_attribute_taxonomies();
                    
                    $i = 0;
                    foreach ( $attribute_taxonomies as $tax ){
                        $taxonomy = wc_attribute_taxonomy_name( $tax->attribute_name );
                        if ( taxonomy_exists( $taxonomy ) ) {
                            $terms = get_terms( $taxonomy, 'orderby=name&hide_empty=0' );
                            if($taxonomy == 'pa_print'){
                                $options = $terms;
                                ?>
                                <div class="image-wrap dokan-hide">
                                    <div class="checkbox">
                                        <?php 
                                        $j = 0;
                                        $arrtax = array();
                                        foreach ($options as $key => $option) {
                                            $arrtax[$key] = $option->term_id;
                                        ?>
                                        <label>
                                            <input name="<?php echo $taxonomy; ?>[term_id][<?php echo $option->term_id; ?>]" type="checkbox" value="<?php echo $option->name; ?>" checked> <?php echo $option->name; ?>
                                        </label>
                                        <?php 
                                        $j++;
                                        } 
                                        ?>
                                    </div>
                                    <div>
                                        <input type="number" class="printnumber" value="30" min="0" max="300" step="1" name="<?php echo $taxonomy; ?>[pacent][<?php echo $option->term_id; ?>]">
                                    </div>
                                </div>
                                <input type="hidden" name="taxcount" value="<?php echo $j; ?>">
                                <?php
                            }else {
                                foreach ($terms as $term) {
                                    ?>
                                    <input name="<?php echo $taxonomy; ?>[term_id][<?php echo $term->term_id; ?>]" type="hidden" value="<?php echo $term->name; ?>">
                                    <?php
                                }
                            }
                            ?>
                            <input type="hidden" name="attribute_names[]" value="<?php echo $taxonomy; ?>">
                            <input type="hidden" name="attribute_is_taxonomy[]" value="1">
                            <input type="hidden" name="attribute_position[]" value="<?php echo $i; ?>">
                            <input type="hidden" name="attribute_visibility[]" value="1">
                            <input type="hidden" name="attribute_variation[]" value="1">   
                            <input type="hidden" name="attribute_variation[]" value="1">  
                            <?php
                        }
                        $i++;
                    }
                    ?>
                    
                    <div class="row product-edit-container dokan-clearfix">
                        <div class="dokan-upload-area">
                            <div class="dokan-feat-image-upload">
                                <div class="instruction-inside">
                                    <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="0">
                                    <i class="fa fa-cloud-upload"></i>
                                    <a href="#" class="dokan-feat-image-btn dokan-btn"><?php _e( 'Upload Product Image', 'dokan' ); ?></a>
                                </div>
                                <?php 
                                if(is_array($options)){
                                    foreach ($options as $count => $option){
                                        $t_id = $option->term_id;
                                        $tax_name = esc_attr( sanitize_title( $option->name ) );
                                        if($tax_name == 'framed-print'){
                                            $class = 'framed-photo-prints-thumb Brown';
                                        }else if($tax_name == 'art-print'){
                                            $class = 'ArtPrint';
                                        }else{
                                            $class = 'canvas no-frame';
                                        }

                                        ?>
                                        <div class="image-wrap dokan-hide">
                                            <div class="slide-overlay <?php echo $class; ?>">
                                                    <img src="" alt="">
                                            </div>
                                            <div class="preview-info">
                                                <span class="preview-name"><?php echo esc_attr( $option->name ); ?></span>
                                            </div>
                                            <input class="att_status" type="checkbox" name="meta_status_print[<?php echo $t_id; ?>]" checked>
                                        </div>
                                        <?php
                                    }
                                }
                                
                                ?>
                            </div>
                        </div>
                        <div class="dokan-info-area dokan-hide">
                            <div class="dokan-form-group">
                                <input class="dokan-form-control" name="post_title" id="post-title" type="text" placeholder="<?php esc_attr_e( 'Product name..', 'dokan' ); ?>" value="<?php echo dokan_posted_input( 'post_title' ); ?>" required="required">
                            </div>
                            <?php /*
                            <div class="dokan-form-group">
                                <div class="dokan-input-group">
                                    <span class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
                                    <input class="dokan-form-control" name="price" id="product-price" type="text" placeholder="9.99" value="<?php echo dokan_posted_input( 'price' ); ?>">
                                </div>
                            </div>
                            */?>
                            <div class="dokan-form-group">
                                <textarea name="post_excerpt" id="post-excerpt" rows="5" class="dokan-form-control" placeholder="<?php esc_attr_e( 'Short description about the product...', 'dokan' ); ?>"><?php echo dokan_posted_textarea( 'post_excerpt' ); ?></textarea>
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
                                    <h5><?php _e( 'Choose a category', 'dokan' );  ?></h5>
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

                                echo str_replace( '<select', '<select data-placeholder="Select product tags" multiple="multiple" ', $drop_down_tags );
                                ?>
                            </div>

                            <!-- <textarea name="post_content" id="" cols="30" rows="10" class="span7" placeholder="Describe your product..."><?php echo dokan_posted_textarea( 'post_content' ); ?></textarea> -->
                            <div class="dokan-form-group">
                                <?php wp_editor( Dokan_Template_Shortcodes::$post_content, 'post_content', array('editor_height' => 50, 'quicktags' => false, 'media_buttons' => false, 'teeny' => true, 'editor_class' => 'post_content') ); ?>
                            </div>

                            <?php do_action( 'dokan_new_product_form' ); ?>

                            <div class="dokan-form-group">
                                <?php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ); ?>
                                <input type="submit" name="add_product" class="dokan-btn dokan-btn-danger dokan-btn-theme" value="<?php esc_attr_e( 'Add Product', 'dokan' ); ?>"/>
                            </div>
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
</div>