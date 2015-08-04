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

	/*load_style( 'cuperortfolio-style', 'cubeportfolio.min.css' );
	load_js( 'cuberportfolio-script', 'jquery.cubeportfolio.min.js' );
	load_js( 'store-artist-script', 'store-artists.js' );*/

	load_style( 'store-list-style', 'store-list.css' );


	get_header();

?>

	<div id="primary" class="content-area col-md-12">
		<div id="content" class="site-content" role="main">

			<header class="entry-header">
				<h1 class="entry-title"><?php the_title(); ?></h1>
			</header>

			<div class="container">


				<div class="works01">

					<div id="grid-container" class="cbp-l-grid-masonry row">

						<?php
							$count      = 0;
							$grid_group = [ ];
							$multi      = null;
							$max        = 6;

							foreach ( $users as $i => $user ):

								if ( ! dokan_is_user_seller( $user->ID ) )
								{
									continue;
								}

								$info['store_settings'] = dokan_get_store_info( $user->ID );
								$info['store_url']      = dokan_get_store_url( $user->ID );
								$info['user_id']        = $user->ID;

								if ( $max == 6 )
								{
									$count += 1;


									if ( $count == 1 )
									{
										$grid_group[] = [ $info ];
										continue;
									}


									if ( $count == 6 )
									{
										$grid_group[] = $multi;
										$grid_group[] = [ $info ];

										$grid_group[] = 'space';

										/*Reset*/
										$multi = null;
										$count = 0;
										$max   = 9;
										continue;
									}

									$multi[] = $info;


									continue;
								}


								if ( $max == 9 )
								{
									$count += 1;

									if ( $count == 5 )
									{
										$grid_group[] = $multi;
										$grid_group[] = [ $info ];

										$multi = null;
										continue;
									}

									if ( $count == 9 )
									{
										$grid_group[] = $multi;

										//reset
										$multi = null;
										$count = 0;
										$max   = 6;
										continue;
									}

									$multi[] = $info;


								}


							endforeach;

						?>


						<?php foreach ( $grid_group as $group ): ?>


							<?php if ( $group == 'space' ): ?>
								<div class="col-md-12"></div>
								<?php continue; endif; ?>

							<?php if ( count( $group ) == 1 ): ?>
								<div class="col-sm-4 grid-group grid-item">
									<a href="<?= $group[0]['store_url'] ?>">
										<?php
											echo get_avatar( $group[0]['user_id'], 350, null, null, [ 'class' => 'author-gal', ] );
										?>

										<h3><?= $group[0]['store_settings']['store_name'] ?></h3>
									</a>

								</div>
							<?php endif; ?>


							<?php if ( count( $group ) > 1 ): ?>
								<div class="col-sm-4 grid-group">
									<?php foreach ( $group as $author ): ?>

										<div class="col-sm-6 grid-item">
											<a href="<?= $author['store_url'] ?>">
												<?php
													echo get_avatar( $author['user_id'], 350, null, null, [ 'class' => 'author-gal', ] );
												?>

												<h3><?= $author['store_settings']['store_name'] ?></h3>
											</a>

										</div>

									<?php endforeach; ?>
								</div>
							<?php endif; ?>


						<?php endforeach; ?>


					</div>


				</div>
				<!-- end works section -->

			</div>

		</div>
		<!-- #content .site-content -->
	</div><!-- #primary .content-area -->

<?php get_footer(); ?>