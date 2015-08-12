<?php
	session_start();

	if ( isset( $_POST['access_code'] ) && $_POST['access_code'] == 'joinushabeebi' )
	{
		$_SESSION['has_site_access'] = true;
		header( 'location: /' );
		exit;
	}

?>


<html>
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<title>Welcome to Mont8 Nation</title>
	<link rel="stylesheet" href="access.css">
</head>
<body>


<div class="content">
	<img src="http://mont8.com/wp-content/uploads/2015/05/logo-pink.jpg" alt="Mont8 Nation"/>

	<p>
		Do you want to join the Mont8 Nation?
	</p>

	<form method="post">

		<input type="password" name="access_code" placeholder="enter code here...">

	</form>

</div>


<script>
	(function (i, s, o, g, r, a, m) {
		i['GoogleAnalyticsObject'] = r;
		i[r] = i[r] || function () {
				(i[r].q = i[r].q || []).push(arguments)
			}, i[r].l = 1 * new Date();
		a = s.createElement(o),
			m = s.getElementsByTagName(o)[0];
		a.async = 1;
		a.src = g;
		m.parentNode.insertBefore(a, m)
	})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

	ga('create', 'UA-65979946-1', 'auto');
	ga('send', 'pageview');

</script>

</body>
</html>