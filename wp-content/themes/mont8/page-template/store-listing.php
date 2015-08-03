<?php
	/**
	 * The Template for displaying a Stores.
	 *
	 * Template Name: Store Listing Page
	 *
	 * @package dokan
	 * @package dokan - 2013 1.0
	 */

	$users = get_users();

	load_style( 'cuperortfolio-style', 'cubeportfolio.min.css' );
	load_js( 'cuberportfolio-script', 'jquery.cubeportfolio.min.js' );
	load_js( 'store-artist-script', 'store-artists.js' );

	get_header();
?>

	<div id="primary" class="content-area col-md-12">
		<div id="content" class="site-content" role="main">

			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="container">


				<div class="works01">

					<div id="grid-container" class="cbp-l-grid-masonry">

						<?php foreach ( $users as $user ): ?>

							<?php


							if ( ! dokan_is_user_seller( $user->ID ) )
							{
								continue;
							}

							$store_settings = dokan_get_store_info( $user->ID );
							$store_url      = dokan_get_store_url( $user->ID );

//			var_dump( $store_settings );

							?>

							<div class="cbp-item">
								<a class="cbp-caption cbp-lightbox" href="<?= $store_url ?>">
									<div class="cbp-caption-defaultWrap">
										<?= get_avatar( $user->ID, null, null, null, [ 'height' => 400 ] ) ?>
									</div>
									<div class="cbp-caption-activeWrap">
										<div class="cbp-l-caption-alignCenter">
											<div class="cbp-l-caption-body">
												<div class="cbp-l-caption-title">
													<h3><?= $store_settings['store_name'] ?></h3></div>
											</div>
										</div>
									</div>
								</a>
							</div>


						<?php endforeach; ?>

					</div>


				</div>
				<!-- end works section -->

			</div>

		</div>
		<!-- #content .site-content -->
	</div><!-- #primary .content-area -->

<?php get_footer(); ?>