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
		$this->app['orchestra.widget'] = $this->app->share(function()
		{
			return new Environment;
		});
	}
}