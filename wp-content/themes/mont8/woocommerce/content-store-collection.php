<?php
	$args = array( 'post_type' => 'product' );

	if(isset($_GET['collection']) && $_GET['collection']){
		$args = array( 'post_type' => 'product',
		               'posts_per_page' => 6,
		               'author'=>$store_user->ID,
		               'tax_query' => array(
			               array(
				               'taxonomy' => 'product_tag',
				               'terms'    => $_GET['collection'],
			               ),
		               )
		);

	}

	$loop = new WP_Query( $args );
?>

<?php $art_count = 0; woocommerce_product_loop_start();  ?>

<?php while ( $loop->have_posts() ) : $loop->the_post();  ?>

	<?php wc_get_template_part( 'content', 'archive-product' ); ?>

	<?php if($art_count%3==2):?>
		<div class="col-md-12">&nbsp;</div>
	<?php endif; ?>

<?php $art_count++; endwhile; wp_reset_query();  // end of the loop.  ?>

<?php woocommerce_product_loop_end(); ?>
