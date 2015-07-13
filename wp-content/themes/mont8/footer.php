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
                    <aside id="email-subscribers-2" class="widget widget_nav_menu"><h3 class="widget-title">Newsletter</h3>
                        <div class="menu-footer-column-1-container">
                            <link rel="stylesheet" media="screen" type="text/css" href="<?= site_url() . '/wp-content/plugins/email-subscribers/widget/es-widget.css' ?>">
                            <script language="javascript" type="text/javascript" src="<?= site_url() . '/wp-content/plugins/email-subscribers/widget/es-widget.js' ?>"></script>
                            <p class="newsletter_title"><b>10%</b> discount when you subscribe for the newsletter</p>
                            <div class="es_msg"><span id="es_msg"></span></div>
                            <div class="newsletter">
                                <div class="input-group">
                                    <input type="email" class="form-control newsletter_txt" name="es_txt_email" id="es_txt_email"  placeholder="Email Address" onkeypress="if(event.keyCode==13) es_submit_page('<?= site_url(); ?>')" maxlength="225">
                                    <span class="input-group-btn">
                                        <button class="btn btn-default btn-go" name="es_txt_button" id="es_txt_button" onclick="return es_submit_page('<?= site_url(); ?>')"  type="button">Go!</button>
                                    </span>
                                </div>
                            </div>
                            <input name="es_txt_name" id="es_txt_name" value="" type="hidden">
                            <input name="es_txt_group" id="es_txt_group" value="" type="hidden">
                        </div>
                    </aside>
                    <!--<aside id="email-subscribers-2" class="widget widget_text elp-widget">
                        <link rel="stylesheet" media="screen" type="text/css" href="<?/*= site_url() . '/wp-content/plugins/email-subscribers/widget/es-widget.css' */?>">
                        <script language="javascript" type="text/javascript" src="<?/*= site_url() . '/wp-content/plugins/email-subscribers/widget/es-widget.js' */?>"></script>
                        <div>
                            <div class="es_msg"><span id="es_msg"></span></div>
                            <div class="es_lablebox">Email *</div>
                            <div class="es_textbox">
                                <input class="es_textbox_class" name="es_txt_email" id="es_txt_email" onkeypress="if(event.keyCode==13) es_submit_page('http://mont8.app:8000')" value="" maxlength="225" type="text">
                            </div>
                            <div class="es_button">
                                <input class="es_textbox_button" name="es_txt_button" id="es_txt_button" onclick="return es_submit_page('http://mont8.app:8000')" value="Subscribe" type="button">
                            </div>
                            <input name="es_txt_name" id="es_txt_name" value="" type="hidden">
                            <input name="es_txt_group" id="es_txt_group" value="" type="hidden">
                        </div>-->
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
		                       printf( __( '&copy; Copyrights %d, %s. All rights are reserved.', 'dokan' ), date( 'Y' ), get_bloginfo( 'name' ) );

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

<script>
    jQuery(document).ready(function($){

	    $(".cart-overlay").click(function () {

		    $(".cart-overlay").fadeToggle();

		    var cartSidebar = $('.cart-sidebar');

		    hideCart = !hideCart;

		    cartSidebar.addClass('slideOutRight').removeClass('slideInRight');

	    });

	    $('[data-toggle="tooltip"]').tooltip();


	    // cart sidebar
	    var hideCart = false;
	    $('.btn-cart-sidebar').click(function (e) {

		    $(".cart-overlay").fadeToggle();

		    var cartSidebar = $('.cart-sidebar');

		    cartSidebar.show();

		    hideCart = !hideCart;

		    if (hideCart) {
			    cartSidebar.addClass('slideInRight').removeClass('slideOutRight');
		    } else {
			    cartSidebar.addClass('slideOutRight').removeClass('slideInRight');
		    }

	    });

	    //search panel
	    var searchPanel = $('.search_panel');
	    var searchPanelInput = $('.search_panel input');
	    var isToggled = false;
	    searchPanel.focusin(function () {
		    isToggled = !isToggled;
		    searchPanel.toggleClass('expand', isToggled);
	    });

	    searchPanelInput.focusout(function () {
		    isToggled = !isToggled;
		    searchPanel.toggleClass('expand', isToggled);
	    });

    });
</script>

<div id="yith-wcwl-popup-message" style="display:none;"><div id="yith-wcwl-message"></div></div>
</body>
</html>