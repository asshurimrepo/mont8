<?php

	$users = get_users();

?>


<link rel="stylesheet" type="text/css" href="<?= get_stylesheet_directory_uri() ?>/iboostme/css/cubeportfolio.min.css">


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
						<?= get_avatar( $user->ID ) ?>
					</div>
					<div class="cbp-caption-activeWrap">
						<div class="cbp-l-caption-alignCenter">
							<div class="cbp-l-caption-body">
								<div class="cbp-l-caption-title"><h3><?= $store_settings['store_name'] ?></h3></div>
							</div>
						</div>
					</div>
				</a>
			</div>


		<?php endforeach; ?>

	</div>


</div><!-- end works section -->


<script type="text/javascript"
        src="<?= get_stylesheet_directory_uri() ?>/iboostme/js/jquery.cubeportfolio.min.js"></script>
<script type="text/javascript" src="<?= get_stylesheet_directory_uri() ?>/iboostme/js/store-artists.js"></script>

