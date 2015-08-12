<?php
/**
 * The Header for our theme.
 *
 * Displays all of the <head> section and everything up till <div id="main">
 *
 * @package dokan
 * @package dokan - 2014 1.0
 */
global $current_user;
$user_id = $current_user->ID;

?><!DOCTYPE html>
<html <?php language_attributes(); ?>>
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>"/>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta name="base_url" content="<?= BASE_URL ?>"/>
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
			<div class="row nav-row">

				<div class="col-xs-12 col-sm-12 col-lg-12 hidden-lg hidden-sm hidden-md mobile-menu">
					<?php dokan_header_user_menu(); ?>
				</div>


				<div class="col-xs-12 visible-xs" style="padding-top: 15px;">
					<img src="<?= get_stylesheet_directory_uri() ?>/assets/images/logo-pink.png" alt="Mont8"
					     class="img-responsive"/>
				</div>

				<div class="col-lg-2 hidden-xs" style="padding:0;">
					<hgroup>
						<h1 class="site-title">
							<a href="<?php echo home_url( '/', 'http' ); ?>"
							   title="<?php echo esc_attr( get_bloginfo( 'name', 'display' ) ); ?>"
							   rel="home"><?php bloginfo( 'name' ); ?>
								<small> - <?php bloginfo( 'description' ); ?></small>
							</a></h1>
					</hgroup>
				</div>


				<div class="col-md-4 pull-right hidden-xs hidden-sm"
				     style="padding:0;">
					<?php dokan_header_user_menu(); ?>
				</div>


				<div class="<?= is_user_logged_in() ? 'col-md-6' : 'col-md-7' ?> nav-menu"
				     style="padding:0; <?= is_user_logged_in() ?: 'margin-top: -72px;' ?>">

					<?php echo wp_nav_menu( array( "theme_location" => "primary" ) ); ?>

					<?php get_template_part( 'iboostme/template-part/upload-btn' ) ?>

				</div>


			</div>
			<!-- .row -->
		</div>
		<!-- .container -->
		<?php get_template_part( 'widgets/widget', 'cart-sidebar' ); ?>

	</header>
	<!-- #masthead .site-header -->

	<div id="main" class="site-main">
		<div class="container content-wrap">
			<div class="row">
