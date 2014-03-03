<?php namespace Orchestra\Widget;

use Closure;
use Orchestra\Support\Manager;

class WidgetManager extends Manager
{
    /**
     * {@inheritdoc}
     */
    protected $blacklisted = array();

    /**
     * Create Menu driver.
     *
     * @param  string   $name
     * @return MenuWidgetHandler
     */
    protected function createMenuDriver($name)
    {
        $config = $this->app['config']->get("orchestra/widget::menu.{$name}", array());

        return new MenuWidgetHandler($name, $config);
    }

    /**
     * Create Pane driver.
     *
     * @param  string   $name
     * @return PaneWidgetHandler
     */
    protected function createPaneDriver($name)
    {
        $config = $this->app['config']->get("orchestra/widget::pane.{$name}", array());

        return new PaneWidgetHandler($name, $config);
    }

    /**
     * Create Placeholder driver.
     *
     * @param  string   $name
     * @return PlaceholderWidgetHandler
     */
    protected function createPlaceholderDriver($name)
    {
        $config = $this->app['config']->get("orchestra/widget::placeholder.{$name}", array());

        return new PlaceholderWidgetHandler($name, $config);
    }

    /**
     * Get the default driver.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->app['config']->get('orchestra/widget::driver', 'placeholder.default');
    }

    /**
     * Set the default driver.
     *
     * @param  string   $name
     * @return void
     */
    public function setDefaultDriver($name)
    {
        $this->app['config']->set('orchestra/widget::driver', $name);
    }

    /**
     * Get the selected driver and extend it via callback.
     *
     * @param  string   $name
     * @param  \Closure $callback
     * @return Factory
     */
    public function of($name, Closure $callback = null)
    {
        if ($name instanceof Closure) {
            $callback = $name;
            $name     = $this->getDefaultDriver();
        }

        $instance = $this->make($name);

        if ($instance instanceof Factory && ! is_null($callback)) {
            call_user_func($callback, $instance);
        }

        return $instance;
    }
}
