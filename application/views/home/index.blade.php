<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ElectroFrontier</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('laravel/css/style.css') }}
	{{ HTML::style('css/app.css') }}
</head>
<body>
	<div id="wrapper">	
		<div id="header">
			<h1>ElectroFrontier</h1>
		</div>
		<div id="body">
			<h1>Tracks</h1>
			<hr />
			<br />
			<?php echo render_each('tracks.list', $tracks, 'track'); ?>
		</div>
	</div>
</body>
</html>
