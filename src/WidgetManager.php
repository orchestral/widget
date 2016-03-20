<?php

namespace Orchestra\Widget;

use Closure;
use Orchestra\Support\Manager;
use Orchestra\Widget\Handlers\Menu;
use Orchestra\Widget\Handlers\Pane;
use Orchestra\Widget\Handlers\Placeholder;

class WidgetManager extends Manager
{
    /**
     * {@inheritdoc}
     */
    protected $blacklisted = [];

    /**
     * Create Menu driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Menu
     */
    protected function createMenuDriver($name)
    {
        $config = $this->app->make('config')->get("orchestra/widget::menu.{$name}", []);

        return new Menu($name, $config);
    }

    /**
     * Create Pane driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Pane
     */
    protected function createPaneDriver($name)
    {
        $config = $this->app->make('config')->get("orchestra/widget::pane.{$name}", []);

        return new Pane($name, $config);
    }

    /**
     * Create Placeholder driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Placeholder
     */
    protected function createPlaceholderDriver($name)
    {
        $config = $this->app->make('config')->get("orchestra/widget::placeholder.{$name}", []);

        return new Placeholder($name, $config);
    }

    /**
     * Get the default driver.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app->make('config')->get('orchestra/widget::driver', 'placeholder.default');
    }

    /**
     * Set the default driver.
     *
     * @param  string  $name
     *
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app->make('config')->set('orchestra/widget::driver', $name);
    }

    /**
     * Get the selected driver and extend it via callback.
     *
     * @param  string  $name
     * @param  \Closure|null  $callback
     *
     * @return \Orchestra\Widget\Handler
     */
    public function of($name, Closure $callback = null)
    {
        if ($name instanceof Closure) {
            $callback = $name;
            $name     = $this->getDefaultDriver();
        }

        $instance = $this->make($name);

        if ($instance instanceof Handler && ! is_null($callback)) {
            call_user_func($callback, $instance);
        }

        return $instance;
    }
}
