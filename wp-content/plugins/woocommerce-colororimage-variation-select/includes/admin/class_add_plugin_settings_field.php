<?php
class wcva_add_shop_swatch_settings {
      
      public function __construct() {
      	add_action( 'woocommerce_product_settings', array(&$this,'wcva_add_product_settings_field' ));
      }


      public function wcva_add_product_settings_field($settings) {
          
          $updated_settings = array();
		  
		    

            foreach ( $settings as $section ) {
				
				

             if ( isset( $section['id'] ) && 'catalog_options' == $section['id'] && isset( $section['type'] ) && 'sectionend' == $section['type'] ) {
                 
				$updated_settings[] = array(
					'title'    => __( 'Shop Swatches Location', 'wcva' ),
					'desc'     => __( 'This controls location of shop swatches on shop/category/archive pages.', 'woocommerce' ),
					'id'       => 'woocommerce_shop_swatches_display',
					'class'    => 'chosen_select',
					'css'      => 'min-width:300px;',
					'default'  => '01',
					'type'     => 'select',
					'options'  => array(
						'01'              => __( 'After Item Title and Price', 'wcva' ),
						'02'              => __( 'Before Item Title and Price', 'wcva' ),
						'03'              => __( 'After Select Options button', 'wcva' ),
						
					),
					'desc_tip' =>  true,
				);
				
				 $updated_settings[] =array(

                          'name'     => __( 'Shop Swatches Height', 'wcva' ),

                          'desc_tip' => __( 'Swatches Height on Shop Page.', 'wcva' ),

                          'id'       => 'woocommerce_shop_swatch_height',

                          'type'     => 'text',

                          'css'      => 'width:35px;',
          
                          'default'  => '32', 

                          'desc'     => 'px'

                   );

                 $updated_settings[] =array(

                          'name'     => __( 'Shop Swatches Width', 'wcva' ),

                          'desc_tip' => __( 'Swatches Width on Shop Page.', 'wcva' ),

                          'id'       => 'woocommerce_shop_swatch_width',

                          'type'     => 'text',

                          'css'      => 'width:35px;',
          
                          'default'  => '32', 

                          'desc'     => 'px'

                   );
				   
				    $updated_settings[] =array(

                          'name'     => __( 'Enable Direct Variation Link on Shop Swatches', 'wcva' ),

                          'id'       => 'woocommerce_shop_swatch_link',

                          'type'     => 'checkbox',
          
                          'default'  => 'no', 

                          'desc_tip'     => 'You will require <a href="https://wordpress.org/plugins/woocommerce-direct-variation-link/">WooCommerce Direct Variation Link</a> Plugin activated before using this feature.'

                   );

    

             }

             $updated_settings[] = $section;

             }
          
          return $updated_settings;
       }
   }

new wcva_add_shop_swatch_settings();
?>