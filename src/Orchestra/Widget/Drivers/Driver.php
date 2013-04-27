<?php namespace Orchestra\Widget\Drivers;

use Countable;
use ArrayIterator;
use IteratorAggregate;
use InvalidArgumentException;
use Illuminate\Support\Facades\Config;
use Orchestra\Widget\Nesty;

abstract class Driver implements Countable, IteratorAggregate {

	/**
	 * Application instance.
	 *
	 * @var Illuminate\Foundation\Application
	 */
	protected $app = null;

	/**
	 * Nesty instance
	 *
	 * @var Orchestra\Widget\Nesty
	 */
	protected $nesty = null;

	/**
	 * Name of this instance.
	 *
	 * @var string
	 */
	protected $name = null;

	/**
	 * Widget Configuration.
	 *
	 * @var array
	 */
	protected $config = array();

	/**
	 * Type of Widget.
	 *
	 * @var string
	 */
	protected $type = null;

	/**
	 * Construct a new instance
	 *
	 * @access  public
	 * @param   Illuminate\Foundation\Application   $app
	 * @param   string                              $name
	 * @return  void
	 */
	public function __construct($app, $name)
	{
		$this->app    = $app;
		$this->config = array_merge(
			Config::get("orchestra/widget::{$this->type}.{$name}", array()), 
			$this->config
		);

		$this->name   = $name;
		$this->nesty  = new Nesty($this->config);
	}

	/**
	 * Add an item to current widget.
	 *
	 * @access public
	 * @param  string   $id
	 * @param  mixed    $location
	 * @param  Closure  $callback
	 * @return mixed
	 */
	public abstract function add($id, $location = 'parent', $callback = null);

	/**
	 * Get all item from Nesty.
	 *
	 * @access public
	 * @return array
	 * @see    Orchestra\Widget\Nesty::getItem()
	 */
	public function getItems()
	{
		return $this->nesty->getItems();
	}

	/**
	 * Magic method to get all items
	 *
	 * @param  string   $key
	 * @return mixed
	 * @throws InvalidArgumentException
	 */
	public function __get($key)
	{
		if ($key !== 'items') 
		{
			throw new InvalidArgumentException("Access to [{$key}] is not allowed.");
		}

		return $this->getItems();
	}

	/**
	 * Get the number of items for the current page.
	 *
	 * @return int
	 */
	public function count()
	{
		return count($this->nesty->getItems());
	}

	/**
	 * Get an iterator for the items.
	 *
	 * @return ArrayIterator
	 */
	public function getIterator()
	{
		return new ArrayIterator($this->nesty->getItems());
	}
}
