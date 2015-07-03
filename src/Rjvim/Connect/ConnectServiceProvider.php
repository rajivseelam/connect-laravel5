<?php namespace Rjvim\Connect;

use Illuminate\Support\ServiceProvider;

class ConnectServiceProvider extends ServiceProvider {

	/**
	 * Indicates if loading of the provider is deferred.
	 *
	 * @var bool
	 */
	protected $defer = false;

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('rjvim/connect-laravel5');

	}

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{

		$config     = realpath(__DIR__.'/../../../config/rjvim.connect.php');
		$migrations = realpath(__DIR__.'/../../migrations');

		$this->mergeConfigFrom($config, 'rjvim.connect');

		$this->publishes([
			$config     => config_path('rjvim.connect.php'),
			$migrations => $this->app->databasePath().'/migrations',
		]);

		$this->app->register('Cartalyst\Sentry\SentryServiceProvider');
		
	 	// Register 'connect'
	    $this->app['connect'] = $this->app->share(function($app)
	    {
	        // create Connect instance
        	$connect = new Connect();
			// return Connect instance
        	return $connect;
	    });

	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides()
	{
		return array();
	}

}
