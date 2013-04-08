<?php namespace Orchestra\Widget;

use InvalidArgumentException,
	Illuminate\Support\Facades\Config;

abstract class Driver {

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
	 * @param   string  $name
	 * @param   array   $config
	 * @return  void
	 */
	public function __construct($name, $config = array())
	{
		$configuration = array_merge(
			Config::get("orchestra::widget.{$this->type}", array()), 
			$this->config
		);

		$this->config = array_merge($configuration, $config);
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
	public function getItem()
	{
		return $this->nesty->getItem();
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

		return $this->getItem();
	}
}