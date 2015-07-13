<?php
	$featured_artworks = IB_Utils::post_to_product( (array) get_field( 'featured_artworks' ) );
	//	var_dump($featured_artworks);
?>


<div id="gallery-freewall"">


<?php foreach ( $featured_artworks as $artwork ): ?>
	<?php $author = get_userdata( $artwork->post->post_author ); ?>
	<?php $preview_price = IB_Utils::get_base_price( $artwork->id ); ?>
	<div class="cell col-sm-3">

		<a href="<?= $artwork->get_permalink() ?>">
			<?= $artwork->get_image( 'shop_catalog', [ 'class' => 'img-responsive', ] ) ?>
		</a>

		<div class="prod-meta">
			<div class="pull-right">
				<?=do_shortcode('[likebtn identifier="'.$artwork->post->ID.'" theme="disk" event_handler="onLike" dislike_enabled="0"  show_like_label="0" icon_dislike_show="0" white_label="1" popup_disabled="1" share_enabled="0"]')?>
			</div>

			<a href="<?= $artwork->get_permalink() ?>" class="invi-link">&nbsp;</a>
			<div class="info">
					<a href="<?= $artwork->get_permalink() ?>"><span class="title"><?= $artwork->get_title() ?></span></a>
					<a href="<?= dokan_get_store_url($author->ID) ?>"><span class="author"><?= $author->display_name ?></span></a>
					<a href="<?= $artwork->get_permalink() ?>"><span class="base-price">From <?= $preview_price ?></span></a>
				</div>
			</div>
	</div>


<?php endforeach; ?>

</div>

<script>
	(function ($) {

		var wall = new freewall("#gallery-freewall");
		wall.reset({
			selector: '.cell',
			animate: true,
			cellW: 20,
			cellH: 200,
			onResize: function () {
				wall.fitWidth();
			}
		});

		wall.fitWidth();

		// for scroll bar appear;
		$(window).trigger("resize");

	})(jQuery);
</script>