<?php
/**
 * The template for displaying the footer.
 *
 * Contains the closing of the id=main div and all content after
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
?>
</div><!-- .row -->
</div><!-- .container -->
</div><!-- #main .site-main -->

<footer id="colophon" class="site-footer" role="contentinfo">
    <div class="footer-widget-area">
        <div class="container">
            <div class="row">

                <div class="col-md-3"><?php dynamic_sidebar('footer-1'); ?></div>
                <div class="col-md-3"><?php dynamic_sidebar('footer-2'); ?></div>
                <div class="col-md-3"><?php dynamic_sidebar('footer-3'); ?></div>
                <div class="col-md-3">


	                <aside id="nav_menu-2" class="widget widget_nav_menu"><h3 class="widget-title">Newsletter</h3><div class="menu-footer-column-1-container">
			                <p class="newsletter_title"><b>10%</b> discount when you subscribe for the newsletter</p>
							<div class="newsletter">
								<div class="input-group">
									<input type="text" class="form-control newsletter_txt" placeholder="Email Address">
				                      <span class="input-group-btn">
				                        <button class="btn btn-default btn-go" type="button">Go!</button>
				                      </span>
								</div>
							</div>
		                </div>
                    </aside>
                    <ul class="list-inline list-unstyled list-payments">
                        <li><a href="#"><img src="<?= THEME_PATH . '/assets/images/payments/cash-delivery.png' ?>" alt="Cash on Delivery"/></a></li>
                        <li><a href="#"><img src="<?= THEME_PATH . '/assets/images/payments/visa.png' ?>" alt="Visa"/></a></li>
                        <li><a href="#"><img src="<?= THEME_PATH . '/assets/images/payments/master-card.png' ?>" alt="Master Card"/></a></li>
                        <li><a href="#"><img src="<?= THEME_PATH . '/assets/images/payments/paypal.png' ?>" alt="Paypal"/></a></li>
                    </ul>
                </div>
                
            </div> <!-- .footer-widget-area -->
        </div>
    </div>

    <div class="copy-container">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="footer-copy">
                       <?php
	                       $footer_text = get_theme_mod( 'footer_text' );

	                       if ( empty( $footer_text ) ) {
		                       printf( __( '&copy; %d, %s. All rights are reserved.', 'dokan' ), date( 'Y' ), get_bloginfo( 'name' ) );

	                       } else {
		                       echo $footer_text;
	                       }
                       ?>
                    </div>
                </div>

            </div><!-- .row -->
        </div><!-- .container -->
    </div> <!-- .copy-container -->
</footer><!-- #colophon .site-footer -->
</div><!-- #page .hfeed .site -->

<?php wp_footer(); ?>

<script src="<?=get_template_directory_uri().'/assets/js/bootstrap-datepicker/js/bootstrap-datepicker.min.js';?>"></script>

<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>
</body>
</html>