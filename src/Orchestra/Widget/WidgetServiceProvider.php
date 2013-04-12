<?php namespace Orchestra\Widget;

use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider {
	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register()
	{
		$this->app['orchestra.widget'] = $this->app->share(function($app)
		{
			return new WidgetManager($app);
		});
	}

	/**
	 * Bootstrap the application events.
	 *
	 * @return void
	 */
	public function boot()
	{
		$this->package('orchestra/widget', 'orchestra/widget');
	}
}