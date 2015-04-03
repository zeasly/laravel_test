<?php namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class MyLogServiceProvider extends ServiceProvider {

	public function register()
	{
		$this->app->bind(
			'MyLog',
			'App\Services\MyLog'
		);
	}

}
