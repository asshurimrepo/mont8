<?php
	$featured_artworks = IB_Utils::post_to_product( (array) get_field( 'featured_artworks' ) );
?>


<div id="gallery-freewall">


	<?php foreach ( $featured_artworks as $artwork ): ?>
		<?php
		$preview_price = IB_Utils::get_base_price( $artwork->id, 'art_print' );
		$store_info    = dokan_get_store_info( $artwork->post->post_author );
		Share::setData( $artwork );
		?>

		<div class="cell col-sm-3">

			<div class="pull-right like-container">
				<?php get_template_part( 'dokan/btn', 'like' ); ?>
			</div>

			<a href="<?= $artwork->get_permalink() ?>">
				<?= $artwork->get_image( 'shop_catalog', [ 'class' => 'img-responsive', ] ) ?>
			</a>

			<div class="prod-meta">

				<a href="<?= $artwork->get_permalink() ?>" class="invi-link">&nbsp;</a>

				<div class="info">
					<a href="<?= $artwork->get_permalink() ?>"><span
							class="title"><?= $artwork->get_title() ?></span></a>
					<a href="<?= dokan_get_store_url( $artwork->post->post_author ) ?>"><span
							class="author"><?= $store_info['store_name'] ?></span></a>
					<a href="<?= $artwork->get_permalink() ?>"><span
							class="base-price">From <?= $preview_price ?></span></a>
				</div>
			</div>
		</div>


	<?php endforeach; ?>

</div>
