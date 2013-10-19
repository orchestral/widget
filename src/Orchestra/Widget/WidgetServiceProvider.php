<?php namespace Orchestra\Widget;

use Illuminate\Support\ServiceProvider;
use Illuminate\Foundation\AliasLoader;

class WidgetServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var boolean
     */
    protected $defer = true;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app['orchestra.widget'] = $this->app->share(function ($app) {
            return new WidgetManager($app);
        });

        $this->app->booting(function () {
            $loader = AliasLoader::getInstance();
            $loader->alias('Orchestra\Widget', 'Orchestra\Support\Facades\Widget');
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

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return array('orchestra.widget');
    }
}
