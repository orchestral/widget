<?php

namespace Orchestra\Widget;

use Orchestra\Support\Providers\ServiceProvider;
use Illuminate\Contracts\Support\DeferrableProvider;

class WidgetServiceProvider extends ServiceProvider implements DeferrableProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('orchestra.widget', static function ($app) {
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
        $path = \realpath(__DIR__.'/../');

        $this->addConfigComponent('orchestra/widget', 'orchestra/widget', $path.'/config');
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
