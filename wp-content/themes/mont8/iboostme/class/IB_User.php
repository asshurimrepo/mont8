<?php

	class IB_User {

		/**
		 * Returns true if published product is > 0
		 *
		 * @return bool
		 */
		public function has_artwork()
		{
			$count_posts = wp_count_posts( 'product' );

			return $count_posts->publish > 0;
		}

	}