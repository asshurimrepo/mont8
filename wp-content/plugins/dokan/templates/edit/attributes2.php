<?php
    $thepostid = $post->ID;
    global $woocommerce;

    // Array of defined attribute taxonomies
    $attribute_taxonomies = wc_get_attribute_taxonomies();

    // Product attributes - taxonomies and custom, ordered, with visibility and variation attributes set
    $attributes = maybe_unserialize( get_post_meta( $thepostid, '_product_attributes', true ) );

    
    $i = -1;
    // Custom Attributes
    if ( ! empty( $attributes ) ) {
        foreach ( $attributes as $attribute ) {
            // var_dump($attribute);


            if ( $attribute['is_taxonomy'] ) {
                $options = wp_get_post_terms( $thepostid, $attribute['name'], array('fields' => 'names') );
            } else {
                $options = array_map( 'trim', explode('|', $attribute['value'] ) );
            }

            $i++;
            
            if($i > 0)
                break;
            
            

            $term_meta = get_option( "pa_print_status_".$thepostid );
            
            $term_id = wp_get_post_terms( $thepostid, $attribute['name'], array('fields' => 'ids') );
            
            $feat_image_id     = 0;
            if ( has_post_thumbnail( $thepostid ) ) {
                $feat_image_id     = get_post_thumbnail_id( $thepostid );
            }
            
            
            ?>

                <div class="box-inside dokan-clearfix">
                        <?php
                        //$wrap_class        = ' dokan-hide';
                        $instruction_class = '';
                        $feat_image_id     = 0;

                        if ( has_post_thumbnail( $post_id ) ) {
                            $wrap_class        = '';
                            //$instruction_class = ' dokan-hide';
                            $feat_image_id     = get_post_thumbnail_id( $post_id );
                        }
                        ?>
                        <div class="dokan-feat-image-upload">
                            <div class="instruction-inside">
                                <input type="hidden" name="feat_image_id" class="dokan-feat-image-id" value="<?php echo $feat_image_id; ?>">

                                <i class="fa fa-cloud-upload"></i>
                                <a href="#" class="dokan-feat-image-btn btn btn-sm"><?php _e( 'Upload a product cover image', 'dokan' ); ?></a>
                            </div>
                            
                            <?php
                            if ($options) {
                                foreach ($options as $count => $option) {
                                    //$tax_id = $term_id[$count];                                   
                                    $tax_name = esc_attr( sanitize_title( $option ) );
                                    if($tax_name == 'framed-print'){
                                        $class = 'framed-photo-prints-thumb Brown';
                                    }else if($tax_name == 'art-print'){
                                        $class = 'ArtPrint';
                                    }else{
                                        $class = 'canvas no-frame';
                                    }                                    
                                    ?>

                                    <div class="image-wrap<?php echo $wrap_class; ?>">
                                        <div class="slide-overlay <?php echo $class; ?>">
                                                <?php if ( $feat_image_id ) { ?>
                                                    <?php //echo get_the_post_thumbnail( $post_id, apply_filters( 'single_product_large_thumbnail_size', 'shop_single' ), array( 'height' => '', 'width' => '' ) ); ?>
                                                    <?php echo get_the_post_thumbnail( $post_id, 'medium', array( 'width' => '400' ) ); ?>
                                                <?php } else { ?>
                                                    <img height="" width="" src="" alt="">
                                                <?php } ?>
                                        </div>
                                        <div class="preview-info">
                                            <span class="preview-name"><?php echo esc_attr( $option ); ?></span>
                                        </div>
                                        <input class="att_status" type="checkbox" name="meta_status_print[<?php echo $i; ?>][<?php echo $tax_id; ?>]" <?php echo ($term_meta[$tax_id] == 'on')?'checked':'' ?> >
                                    </div>

                                    <?php
                                }
                            }
                            ?>
                        </div>
                        
                        

                </div> <!-- .box-inside -->
        <?php } ?>
    <?php } ?>

                <?php
                

        //print_r($attributes);
        $_coloredvariables = array();
        
        $product = new WC_Product_Variable( $thepostid );
	$attributes = $product->get_variation_attributes();
        
        if ((!empty($attributes)) && (sizeof($attributes) >0)){
            foreach ($attributes as $key=>$values){
                if($key = 'pa_print'){
                    $_coloredvariables[$key]['label'] = 'Print';
                    $_coloredvariables[$key]['display_type'] = 'colororimage';
                    $_coloredvariables[$key]['size'] = 'small';
                    $_coloredvariables[$key]['displaytype'] = 'square';
                    $_coloredvariables[$key]['show_name'] = 'no';
                    
                    foreach ($values as $k=>$val){
                        $_coloredvariables[$key]['values'][$val]['type'] = 'Image';
                        $_coloredvariables[$key]['values'][$val]['color'] = '#ffffff';
                        $_coloredvariables[$key]['values'][$val]['image'] = $feat_image_id;
                        $_coloredvariables[$key]['values'][$val]['hoverimage'] = '';
                    }
                    break;
                }

            }
            foreach ($attributes as $key=>$values){
                if($key != 'pa_size')
                    continue;
                if($key = 'pa_size'){
                    $_coloredvariables[$key]['label'] = 'Size';
                    $_coloredvariables[$key]['display_type'] = 'none';
                    $_coloredvariables[$key]['size'] = 'small';
                    $_coloredvariables[$key]['displaytype'] = 'square';
                    $_coloredvariables[$key]['show_name'] = 'no';
                    foreach ($values as $val){
                        $_coloredvariables[$key]['values'][$val]['type'] = 'Image';
                        $_coloredvariables[$key]['values'][$val]['color'] = '#ffffff';
                        $_coloredvariables[$key]['values'][$val]['image'] = 0;
                        $_coloredvariables[$key]['values'][$val]['hoverimage'] = '';
                    }
                    break;
                }

            }
        }
        
        //update_post_meta( $post_id, '_coloredvariables', $_coloredvariables );
                
                
                //print_r($_coloredvariables);
                /*$_coloredvariables = array('pa_print' => array
        (
            'label' => 'Print',
            'display_type' => 'colororimage',
            'size' => 'small',
            'displaytype' => 'square',
            'show_name' => 'no',
            'values' => array
                (
                    'framed-print' => array
                        (
                            'type' => 'Image',
                            'color' => '#ffffff',
                            'image' => '110',
                            'hoverimage' => '',
                        ),

                    'canvas-print' => array
                        (
                            'type' => 'Image',
                            'color' => '#ffffff',
                            'image' => '114',
                            'hoverimage' => '',
                        ),

                    'art-print' => array
                        (
                            'type' => 'Image',
                            'color' => '#ffffff',
                            'image' => '112',
                            'hoverimage' => '',
                        )

                )

        ),

    'pa_size' => array
        (
            'label' => 'Size',
            'display_type' => 'none',
            'size' => 'small',
            'displaytype' => 'square',
            'show_name' => 'no',
            'values' => array
                (
                    'a1' => array
                        (
                            'type' => 'Color',
                            'color' => '#ffffff',
                            'image' => '0',
                            'hoverimage' => '',
                        ),

                    'a2' => array
                        (
                            'type' => 'Color',
                            'color' => '#ffffff',
                            'image' => '0',
                            'hoverimage' => '',
                        ),

                    'a3' => array
                        (
                            'type' => 'Color',
                            'color' => '#ffffff',
                            'image' => '0',
                            'hoverimage' => '',
                        ),

                    'a4' => array
                        (
                            'type' => 'Color',
                            'color' => '#ffffff',
                            'image' => '0',
                            'hoverimage' => '',
                        ),

                    'a5' => array
                        (
                            'type' => 'Color',
                            'color' => '#ffffff',
                            'image' => '0',
                            'hoverimage' => '',
                        )

                )

        )

);*/
                update_post_meta( $thepostid, '_coloredvariables', $_coloredvariables );
                ?>