<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Simply tell Laravel the HTTP verbs and URIs it should respond to. It is a
| breeze to setup your application using Laravel's RESTful routing and it
| is perfectly suited for building large applications and simple APIs.
|
| Let's respond to a simple GET request to http://example.com/hello:
|
|		Route::get('hello', function()
|		{
|			return 'Hello World!';
|		});
|
| You can even respond to more than one URI:
|
|		Route::post(array('hello', 'world'), function()
|		{
|			return 'Hello World!';
|		});
|
| It's easy to allow URI wildcards using (:num) or (:any):
|
|		Route::put('hello/(:any)', function($name)
|		{
|			return "Welcome, $name.";
|		});
|
*/


/**
 * Route To : "dashboard"
 * Before   : "auth",
 * Action   : "get",
 * 
 * Default View : "user.dashboard",
 * 
 * Method: Checks whether or not your logged in.
 * 		   Then proceeds to load the "user.dashboard" view.
 *         
 *         @todo  Determine what all goes into this view / route.
 *         @todo  Create a pagination system.
 *         @todo  ??
 */
Route::get('dashboard', array('before' => 'auth', function(){
	$tracks = Track::all();

	//return View::make('tracks.list') -> with('tracks' , $tracks);
	return View::make('user.dashboard')->with(array('user' => Auth::user(), 'tracks' => $tracks));
}));


Route::get('admin', array('before' => 'auth', function() {}));



/**
 * Route To : "logout",
 * Before   : "auth",
 * Action   : "get",
 * 
 * Method   : Destroys the current user's session and data. Logs the user
 * 			  Out of the system.
 * 
 */
Route::get('logout', array('before' => 'auth', function(){
	Auth::logout();
	return Redirect::to('/');
}));

/**
 * @link login
 * @method  post
 * Before   : "csrf",
 * Action   : "post",
 * 
 * Default View: "user.login",
 * 
 * Redirect: "dashboard",
 * 
 * Method: Verifies the user's data, and goes through the validation 
 * 		   process to secure the information.
 * 
 * 		   Next step is to go through the Authentication library and check whether the 
 *         user has valid access or not.
 *         
 *         We then redirect them to their "dashboard" page if it's successful, 
 *         we redraw the "login" view to retry.
 *         
 *         @todo Forgot Password
 *         @todo Groups / Roles
 *         @todo Email Verification
 *         @todo 
 */
Route::post('login', array('before' => 'csrf', function(){
	// Check if the user is
	// already logged in.
	// If he  / she is
	// redirect them to their dashboards.
	if(Auth::check()) return Redirect::to('dashboard');


	// Setting up the validation rules.
	$rules = array(
		'username' => 'required',
		'password' => 'required'
	);

	// Run the validator.
	$validation = Validator::make(Input::all(), $rules);

	// Check for a failure.
	if($validation->fails())
	{	
		// Return the user back to the login page
		// if the validation fails. Send
		// with the errors too.
		return View::make('user.login')->with('validation', $validation);
	}

	// Get the userdata and format it.
	$userdata = array(
		'username' 		=> Input::get('username'),	// Username field.
		'password' 		=> Input::get('password')	// Password field.
	);

	// Attempt a valid authentication
	// with the 'Auth' library.
	if(Auth::attempt($userdata))
	{
		// show the dashboard
		// and pass the current user
		return Redirect::to('dashboard');
	}
	else
	{
		// Else:
		// Show the login page again, and display the new error.
		return View::make('user.login') ->with('error', 'The credentials doesn\'t match a current user.');
	}
}));







// Authentication Form.
Route::get('login', function(){
	if(Auth::check())
		return Redirect::to('dashboard');

	// Show the login view;
	return View::make('user.login');
});



Route::post('register', function(){
	if(Auth::check())
		return Redirect::to('dashboard');

	$rules = array(
		'username' 			=> 'required',
		'password' 			=> 'required',
		'confirmpassword' 	=> 'required',
		'email'			  	=> 'required'
	);

	$validation = Validator::make(Input::all(), $rules);

	if($validation->fails())
	{
		return View::make('user.register')->with('validation', $validation);
	}

	// Check for duplicate username / email.
	$user = User::where('username', '=', Input::get('username'))
			->or_where('email', '=', Input::get('email'))->get();
	if(count($user) > 0)
		return View::make('user.register')->with('error', 'Username and / or email has already been used.');
	else
	{
		// Check for the two passwords being the same.
		if(Input::get('password') == Input::get('confirmpassword'))
		{

			$values = array(
				'username' 		=> Input::get('username'),
				'email' 		=> Input::get('email'),
				'password'      => Hash::make(Input::get('password')),
				'salt'			=> Hash::make(Str::random(32) . Input::get('username') . Input::get('email') ),
				'banned' 		=> false,
				'activated'		=> true
			);

			$user = new User($values);
			$user->save();

			if($user)
			{
				// Log the user in.
				Auth::login($user->id);
				return Redirect::to('dashboard');
			}
			else
			{
				return View::make('user.register') -> with('error', 'The registration failed. Please try again.');
			}

		}
		else
		{
			return View::make('user.register') -> with('error', 'Passwords do not match');
		}

	}

});


Route::get('register', function(){
	if(Auth::check())
		return Redirect::to('dashboard');
	return View::make('user.register');
});






Route::get('tracks/(:any)', function($key){

	$track = Track::where('urlkey', '=', $key)->take(1)->get();
	if(count($track) > 0)
		return View::make('tracks.view') -> with('track', $track);
	return Response::error('404');
});













Route::get('/', function()
{
	$track = new Track(array(
			'admin' => 1,
			'status' => 1, // Free, 2 = Buy
			'title' => 'Little Dragon - Twice (LSB Bootleg)',
			'track_artist' => 1,
			'urlkey' => 'djdjd^#*BXCB@!*#@&(SHS', // Random Key for download.
			'result_purchase_url' => 'http://www.little-dragon.se',
			'result_download_url' => 'http://www.little-dragon.se',
			'player_download_url' => 'http://www.little-dragon.se',
		));
	//$track->save();
	
	$user = new User(array(
			'username' => 'TheHydroImpulse',
			'email'    => 'dnfagnan@gmail.com',
			'password' => 'password',
			'salt'     => 'd483jddj',
			'banned'   => false,
			'activated' => true
		));
	//$user->save();

	$tracks = Track::all();

	return View::make('tracks.index') -> with('tracks' , $tracks);
});




/*
|--------------------------------------------------------------------------
| Application 404 & 500 Error Handlers
|--------------------------------------------------------------------------
|
| To centralize and simplify 404 handling, Laravel uses an awesome event
| system to retrieve the response. Feel free to modify this function to
| your tastes and the needs of your application.
|
| Similarly, we use an event to handle the display of 500 level errors
| within the application. These errors are fired when there is an
| uncaught exception thrown in the application.
|
*/

Event::listen('404', function()
{
	return Response::error('404');
});

Event::listen('500', function()
{
	return Response::error('500');
});

/*
|--------------------------------------------------------------------------
| Route Filters
|--------------------------------------------------------------------------
|
| Filters provide a convenient method for attaching functionality to your
| routes. The built-in before and after filters are called before and
| after every request to your application, and you may even create
| other filters that can be attached to individual routes.
|
| Let's walk through an example...
|
| First, define a filter:
|
|		Route::filter('filter', function()
|		{
|			return 'Filtered!';
|		});
|
| Next, attach the filter to a route:
|
|		Router::register('GET /', array('before' => 'filter', function()
|		{
|			return 'Hello World!';
|		}));
|
*/

Route::filter('before', function()
{
	// Do stuff before every request to your application...
});

Route::filter('after', function($response)
{
	// Do stuff after every request to your application...
});

Route::filter('csrf', function()
{
	if (Request::forged()) return Response::error('500');
});

Route::filter('auth', function()
{
	if (Auth::guest()) return Redirect::to('login');
});

Route::filter('admin.auth', function()
{
	if(Auth::guest()) return Redirect::to('admin/login');
});