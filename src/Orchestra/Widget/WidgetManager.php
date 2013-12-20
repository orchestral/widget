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
     * {@inheritdoc}
     */
    protected function getDefaultDriver()
    {
        return 'placeholder.default';
    }
}
