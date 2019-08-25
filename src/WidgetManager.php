<?php

namespace Orchestra\Widget;

use Closure;
use Orchestra\Support\Manager;
use Orchestra\Widget\Handlers\Placeholder;

class WidgetManager extends Manager
{
    /**
     * {@inheritdoc}
     */
    protected $blacklisted = [];

    /**
     * Create Dash driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Dash
     */
    protected function createDashDriver(string $name): Handlers\Dash
    {
        $config = $this->config->get("orchestra/widget::dash.{$name}", []);

        return new Handlers\Dash($name, $config);
    }

    /**
     * Create Menu driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Menu
     */
    protected function createMenuDriver(string $name): Handlers\Menu
    {
        $config = $this->config->get("orchestra/widget::menu.{$name}", []);

        return new Handlers\Menu($name, $config);
    }

    /**
     * Create Pane driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Pane
     */
    protected function createPaneDriver(string $name): Handlers\Pane
    {
        $config = $this->config->get("orchestra/widget::pane.{$name}", []);

        return new Handlers\Pane($name, $config);
    }

    /**
     * Create Placeholder driver.
     *
     * @param  string  $name
     *
     * @return \Orchestra\Widget\Handlers\Placeholder
     */
    protected function createPlaceholderDriver(string $name): Handlers\Placeholder
    {
        $config = $this->config->get("orchestra/widget::placeholder.{$name}", []);

        return new Handlers\Placeholder($name, $config);
    }

    /**
     * Get the default driver.
     *
     * @return string
     */
    public function getDefaultDriver()
    {
        return $this->config->get('orchestra/widget::driver', 'placeholder.default');
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
        $this->config->set('orchestra/widget::driver', $name);
    }

    /**
     * Get the selected driver and extend it via callback.
     *
     * @param  string|\Closure  $name
     * @param  \Closure|null  $callback
     *
     * @return \Orchestra\Widget\Handler
     */
    public function of($name, Closure $callback = null): Handler
    {
        if ($name instanceof Closure) {
            $callback = $name;
            $name = $this->getDefaultDriver();
        }

        $instance = $this->make($name);

        if ($instance instanceof Handler && ! \is_null($callback)) {
            $callback($instance);
        }

        return $instance;
    }
}
