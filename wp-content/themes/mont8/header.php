<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title><?php wp_title( '|', true, 'right' ); ?></title>
	<link rel="profile" href="http://gmpg.org/xfn/11"/>
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>"/>
	<!-- <link rel="stylesheet" href="<?= CSS_THEME_PATH ?>"/> -->

	<!--[if lt IE 9]>
	<script src="<?php echo get_template_directory_uri(); ?>/assets/js/html5.js" type="text/javascript"></script>
	<![endif]-->

	<?php wp_head(); ?>
</head>

<body <?php body_class(); ?>>

<div id="page" class="hfeed site">
	<?php do_action( 'before' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="container">
			<div class="row">

				<div class="col-xs-12 col-sm-12 col-lg-12 hidden-lg hidden-sm hidden-md mobile_view">
					<?php dokan_header_user_menu(); ?>
				</div>


				<div class="col-xs-12 col-sm-12 col-lg-2" style="padding:0;">
					<hgroup>
						<h1 class="site-title"><a href="<?php echo home_url( '/' ); ?>"
						                          title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
						                          rel="home"><?php bloginfo( 'name' ); ?>
								<small> - <?php bloginfo( 'description' ); ?></small>
							</a></h1>
					</hgroup>
				</div>


				<div class="col-xs-12 col-sm-7 col-lg-7" style="padding:0;">
					<?php echo wp_nav_menu( array( "theme_location" => "primary" ) ); ?>
					<!--<nav role="navigation" class="site-navigation main-navigation clearfix">
                                <h1 class="assistive-text"><i class="icon-reorder"></i> <?php //_e( 'Menu', 'dokan' ); ?></h1>
                                <div class="assistive-text skip-link"><a href="#content" title="<?php //esc_attr_e( 'Skip to content', 'dokan' ); ?>"><?php //_e( 'Skip to content', 'dokan' ); ?></a></div>
                                    <nav role="navigation">
                                       <div class="navbar-header">
                                            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-main-collapse">
                                                <span class="sr-only"><?php //_e( 'Toggle navigation', 'dokan' ); ?></span>
                                                <i class="fa fa-bars"></i>
                                            </button>                                            
                                        </div>
                                        <div class="collapse navbar-collapse navbar-main-collapse">
                                            <?php /*?><?php
                                                wp_nav_menu( array(
                                                    'theme_location'    => 'primary',
                                                    'container'         => 'div',
                                                    'container_class'   => 'collapse navbar-collapse navbar-main-collapse',
                                                    'menu_class'        => 'nav navbar-nav',
                                                    'fallback_cb'       => 'wp_bootstrap_navwalker::fallback',
                                                    'walker'            => new wp_bootstrap_navwalker())
                                                );
                                            ?><?php */ ?>
                                        </div>
                                    </nav>
                            </nav>-->
				</div>


				<div class="col-xs-12 col-sm-5 col-lg-3 hidden-xs" style="padding:0;">
					<?php dokan_header_user_menu(); ?>
				</div>

			</div>
			<!-- .row -->
		</div>
		<!-- .container -->


	</header>
	<!-- #masthead .site-header -->

	<div id="main" class="site-main">
		<div class="container content-wrap">
			<div class="row">
