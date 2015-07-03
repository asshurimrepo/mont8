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
			<div class="hide">
				<?=do_shortcode("[yith_wcwl_add_to_wishlist product_id={$artwork->id}]")?>
			</div>
			<button onclick="jQuery('[data-product-id=<?=$artwork->id?>]').get(0).click();" class="wishlist btn btn-default" data-toggle="tooltip" title="Like this Artwork"><i class="fa fa-heart"></i></button>
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