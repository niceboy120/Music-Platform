<!doctype html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>ElectroFrontier</title>
	<meta name="viewport" content="width=device-width">
	{{ HTML::style('css/bootstrap/bootstrap.min.css') }}
	{{ HTML::style('css/app.css') }}

	<!-- JQuery -->
	{{ HTML::script('http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js')}}

	<!-- Bootstrap -->
	{{ HTML::script('js/bootstrap/bootstrap.min.js') }}

</head>
<body>
	<div id="wrapper">	
		<div id="container">
			<div id="header">
				<h1>ElectroFrontier</h1>
				<div style="display:inline-block">
					@if (!Auth::check())
						{{ HTML::link('login', 'Login')}} |
						{{ HTML::link('register', 'Register')}}
					@else
						{{ HTML::link('logout', 'Logout')}}
					@endif
				</div>

				<!-- Navigation -->
				<ul id="navigation">
					 @if (Auth::check())
					 <li class="dropdown">
				        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><i class="icon-user icon-white"></i>  		
				            <?php echo Auth::user()->username; ?>
				        <b class="caret"></b></a>
				        <ul class="dropdown-menu">
							<li><a href="#mydashboard"><i class="icon-headphones"></i> My Dashboard</a></li>
							<li><a href="#user/settings"><i class="icon-pencil"></i> Edit Profile</a></li>
							<li><a href="#"><i class="icon-music"></i> Playlists</a></li>
							<li><a href=""><i class="icon-remove-circle"></i> Logout</a></li>
							<li class="divider"></li>
							<li><a href="#"><i class="i"></i> Make admin</a></li>
						</ul>
				    </li>
				    @endif
				</ul><!-- ./#navigation -->

			</div>
			<div id="body">
				@yield('content')
			</div>
		</div>
	</div>
</body>
</html>
