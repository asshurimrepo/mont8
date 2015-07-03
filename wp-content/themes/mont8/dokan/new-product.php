<?php

	//begin customization
	upload_artwork_script();
//	User_Actions::listens();

	include_once DOKAN_LIB_DIR . '/class.category-walker.php';

?>

<div class="dokan-dashboard-wrap">
	<?php dokan_get_template( 'dashboard-nav.php', array( 'active_menu' => 'product' ) ); ?>

	<div class="dokan-dashboard-content">

		<div class="dokan-new-product-area">

			<?php if ( Dokan_Template_Shortcodes::$errors )
			{ ?>
				<div class="dokan-alert dokan-alert-danger">
					<a class="dokan-close" data-dismiss="alert">&times;</a>

					<?php foreach ( Dokan_Template_Shortcodes::$errors as $error )
					{ ?>

						<strong><?php _e( 'Error!', 'dokan' ); ?></strong> <?php echo $error ?>.<br>

					<?php } ?>
				</div>
			<?php } ?>

			<?php

				$can_sell = apply_filters( 'dokan_can_post', true );

				if ( $can_sell )
				{

					if ( dokan_is_seller_enabled( get_current_user_id() ) )
					{ ?>


						<!-- New Artwork Uploader -->

						<a id="add-new-artwork"
						   class="dropzone uploader row--popsbear dz-clickable">

							<div class="dz-default dz-message"><span>
                <i class="fa fa-cloud-upload"></i>
                    <br>Click here to begin adding your artwork
                </span></div>
						</a>


						<div id="selection"></div>

						<div class="errors"></div>

						<div id="new-product-form"></div>

						<!-- Handle Bar Tempalte -->
						<script id="entry-template" type="text/x-handlebars-template">

							<form class="dokan-form-container row art-{{ id }}" method="post">

								<div class="row product-edit-container dokan-clearfix">
									<div class="dokan-w4 col-md-5">
										<input type="hidden" name="feat_image_id" class="dokan-feat-image-id"
										       value="{{ id }}">
										<img src="{{ url }}" class="img-responsive img-thumbnail">
									</div>
									<div class="dokan-w6 col-md-7">
										<div class="dokan-form-group">
											<input class="dokan-form-control" name="post_title" id="post-title"
											       type="text"
											       placeholder="<?php esc_attr_e( 'Artwork Name', 'dokan' ); ?>"
											       value="{{ title }}">
										</div>

										<div class="dokan-form-group hide">
											<div class="dokan-input-group">
												<span
													class="dokan-input-group-addon"><?php echo get_woocommerce_currency_symbol(); ?></span>
												<input class="dokan-form-control" name="price" id="product-price"
												       type="text" placeholder="0.00"
												       value="<?php echo dokan_posted_input( 'price' ); ?>">
											</div>
										</div>

										<div class="dokan-form-group">
											<textarea name="post_content" id="post-content" rows="5"
											          class="dokan-form-control"
											          placeholder="<?php esc_attr_e( 'Brief Description', 'dokan' ); ?>">{{ description }}</textarea>
										</div>

										<?php //get_template_part( 'iboostme/dashboard/new-product-gallery', 'form' ) ?>

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
											<h4><?php _e( 'Choose a category', 'dokan' ); ?></h4>
											<div class="dokan-form-group">
												<ul class="dokan-checkbox-cat row">
													<?php
														include_once DOKAN_LIB_DIR . '/class.category-walker.php';
														wp_list_categories( array(

															'walker'       => new DokanCategoryWalker(),
															'title_li'     => '',
															'id'           => 'product_cat',
															'hide_empty'   => 0,
															'taxonomy'     => 'product_cat',
															'hierarchical' => 1,
															'selected'     => array()
														) );
													?>
												</ul>
											</div>
										<?php endif; ?>

										<div class="dokan-form-group">

											<h4><?php _e( 'Choose Product', 'dokan' ); ?></h4>

											<div class="dokan-form-group">
												<ul class="dokan-checkbox-cat">
													<?php
														wp_list_categories( array(

															'walker'       => new DokanTagWalker(),
															'title_li'     => '',
															'id'           => 'product_tag',
															'hide_empty'   => 0,
															'taxonomy'     => 'product_tag',
															'hierarchical' => 1,
															'selected'     => array()
														) );

													?>
												</ul>
											</div>
										</div>

										<input type="submit" class="dokan-btn dokan-btn-danger dokan-btn-theme"
										       value="<?php esc_attr_e( 'Save Artwork', 'dokan' ); ?>"/>

										<p><a href="#!" class="change-product-pricing-btn">Change products and pricing
												for this art piece</a></p>
									</div>
								</div>


								<?php get_template_part( 'iboostme/single-product/product', 'pricing' ); ?>


								<?php do_action( 'dokan_new_product_form' ); ?>

								<div class="dokan-form-group">
									<?php wp_nonce_field( 'dokan_add_new_product', 'dokan_add_new_product_nonce' ); ?>
									<input type="hidden" name="add_product" value="1"/>
								</div>

							</form>

						</script>


						<hr/>

						<a href="<?=get_permalink_by_slug('upload-guideline-explained')?>">Have questions about uploading images?</a>

						<?php /*Gallery*/ //get_template_part( 'iboostme/dashboard/new-product-gallery', 'modal-form' ) ?>


					<?php }
					else
					{ ?>

						<?php dokan_seller_not_enabled_notice(); ?>

					<?php } ?>

				<?php }
				else
				{ ?>

					<?php do_action( 'dokan_can_post_notice' ); ?>

				<?php } ?>
		</div>
		<!-- #primary .content-area -->
	</div>
	<!-- .dokan-dashboard-wrap -->