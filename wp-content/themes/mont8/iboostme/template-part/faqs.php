<?php
	load_js( 'faq-script', 'faq.js' );
	$faqs = get_field( 'topics' );

?>

<div class="col-md-3">


	<ul class="list-unstyled">

		<?php foreach ( $faqs as $i => $faq ): ?>
			<li class="faq-topic <?= $i ?: 'active' ?>" id="topic-<?= $i ?>">
				<a href="#topic-page-<?= $i ?>"><i class="fa fa-angle-double-right"></i> <?= $faq['topic_title'] ?></a>
			</li>
		<?php endforeach; ?>

	</ul>

</div>
<div class="col-md-9">

	<?php foreach ( $faqs as $i => $faq ): ?>

		<section class="<?= ! $i ?: 'hide' ?> topic-page-item" id="topic-page-<?= $i ?>">

			<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">


				<?php foreach ( $faq['items'] as $ii => $item ): $id = rand( 0, 9999 ) . $ii; ?>

					<div class="panel panel-default">
						<div class="panel-heading" role="tab" id="<?= $id ?>">
							<h4 class="panel-title">
								<a role="button" data-toggle="collapse" data-parent="#accordion"
								   href="#collapse<?= $id ?>"
								   aria-expanded="true" aria-controls="collapse<?= $id ?>">
									<?= $item['question'] ?>
								</a>
							</h4>
						</div>
						<div id="collapse<?= $id ?>" class="panel-collapse collapse" role="tabpanel"
						     aria-labelledby="$id">
							<div class="panel-body"><?= nl2br( $item['answer'] ) ?></div>
						</div>
					</div>


				<?php endforeach; ?>

			</div>

		</section>

	<?php endforeach; ?>

</div>

