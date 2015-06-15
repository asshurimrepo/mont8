<?php

// Constants
	define( 'THEME_PATH', get_template_directory_uri() );


// Change avatar css
	add_filter( 'get_avatar', 'change_avatar_css' );

	function change_avatar_css( $class )
	{
		$class = str_replace( "class='avatar", "class='avatar img-circle", $class );

		return $class;
	}


	//	Disqus shortcode
	function disqus_embed( $disqus_shortname )
	{
		global $post;
		wp_enqueue_script( 'disqus_embed', 'http://' . $disqus_shortname . '.disqus.com/embed.js' );
		echo '<div id="disqus_thread"></div>
		    <script type="text/javascript">
		        var disqus_shortname = "' . $disqus_shortname . '";
		        var disqus_title = "' . $post->post_title . '";
		        var disqus_url = "' . get_permalink( $post->ID ) . '";
		        var disqus_identifier = "' . $disqus_shortname . '-' . $post->ID . '";
		    </script>';
	}