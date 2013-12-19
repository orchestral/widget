<?php namespace Orchestra\Widget;

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
     * @return Drivers\Menu
     */
    protected function createMenuDriver($name)
    {
        $config = $this->app['config']->get("orchestra/widget::menu.{$name}", array());

        return new Drivers\Menu($name, $config);
    }

    /**
     * Create Pane driver.
     *
     * @param  string   $name
     * @return Drivers\Pane
     */
    protected function createPaneDriver($name)
    {
        $config = $this->app['config']->get("orchestra/widget::pane.{$name}", array());

        return new Drivers\Pane($name, $config);
    }

    /**
     * Create Placeholder driver.
     *
     * @param  string   $name
     * @return Drivers\Placeholder
     */
    protected function createPlaceholderDriver($name)
    {
        $config = $this->app['config']->get("orchestra/widget::placeholder.{$name}", array());

        return new Drivers\Placeholder($name, $config);
    }

    /**
     * {@inheritdoc}
     */
    protected function getDefaultDriver()
    {
        return 'placeholder.default';
    }
}
