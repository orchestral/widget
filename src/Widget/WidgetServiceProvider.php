<?php namespace Orchestra\Widget;

use Illuminate\Support\ServiceProvider;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bindShared('orchestra.widget', function ($app) {
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
        $path = realpath(__DIR__.'/../');

        $this->package('orchestra/widget', 'orchestra/widget', $path);
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['orchestra.widget'];
    }
}
