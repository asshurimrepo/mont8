<?php
	load_product_page_assets();
	echo do_shortcode('[product_page id='. $_GET['prod_id'] .']');