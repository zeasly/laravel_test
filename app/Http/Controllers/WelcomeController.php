<?php namespace App\Http\Controllers;

class WelcomeController extends Controller {

	/*
	|--------------------------------------------------------------------------
	| Welcome Controller
	|--------------------------------------------------------------------------
	|
	| This controller renders the "marketing page" for the application and
	| is configured to only allow guests. Like most of the other sample
	| controllers, you are free to modify or remove it as you desire.
	|
	*/

	/**
	 * Create a new controller instance.
	 *
	 * @return void
	 */
	public function __construct()
	{
		$this->middleware('guest');
	}

	/**
	 * Show the application welcome screen to the user.
	 *
	 * @return Response
	 */
	public function index()
	{
		// \DB::listen(function($sql, $bindings, $time)
		// {
		// 	\Log::info([$sql, $bindings]);
		// });
		$user = \App\User::where('aaa', '=', '1') ->get();
		// $user = \App\User::find(1);

		// dd($user);
		// 1
		return view('welcome');
	}

}
