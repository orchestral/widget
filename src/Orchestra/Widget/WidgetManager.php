<?php namespace Orchestra\Widget;

use InvalidArgumentException;
use Closure;
use Orchestra\Support\Manager;

class WidgetManager extends Manager {

	/**
	 * Create Menu driver.
	 * 
	 * @access protected
	 * @param  string   $name
	 * @return \Orchestra\Widget\Drivers\Menu
	 */
	protected function createMenuDriver($name)
	{
		return new Drivers\Menu($this->app, $name);
	}

	/**
	 * Create Pane driver.
	 * 
	 * @access protected
	 * @param  string   $name
	 * @return \Orchestra\Widget\Drivers\Pane
	 */
	protected function createPaneDriver($name)
	{
		return new Drivers\Pane($this->app, $name);
	}

	/**
	 * Create Placeholder driver.
	 * 
	 * @access protected
	 * @param  string   $name
	 * @return \Orchestra\Widget\Drivers\Placeholder
	 */
	protected function createPlaceholderDriver($name)
	{
		return new Drivers\Placeholder($this->app, $name);
	}

	/**
	 * Create default driver.
	 * 
	 * @access protected
	 * @param  string   $name
	 * @return \Orchestra\Widget\Drivers\Placeholder
	 */
	protected function getDefaultDriver()
	{
		return 'placeholder.default';
	}
}
