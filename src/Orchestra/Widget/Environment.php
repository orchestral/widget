<?php namespace Orchestra\Widget;

use InvalidArgumentException,
	Closure;

class Environment {

	/**
	 * The third-party driver registrar.
	 *
	 * @var array
	 */
	protected $registrar = array();

	/**
	 * Cache widget instance so we can reuse it
	 *
	 * @access  protected
	 * @var     array
	 */
	protected $instances = array();

	/**
	 * Create a new Widget service.
	 *
	 * @access public
	 * @return void
	 */
	public function __construct() 
	{
		$this->registrar = array();
		$this->instances = array();
	}

	/**
	 * Create a new Widget instance.
	 *
	 * @access public
	 * @param  string   $driver  a string identifying the widget
	 * @param  array    $config  a configuration array
	 * @return Orchestra\Widget\Driver
	 */
	public function make($driver, $config = array()) 
	{
		// the "driver" string might not contain a using "{$type}.{$name}" 
		// format, if $name is missing let use "default" as $name.
		if (false === strpos($driver, '.')) $driver = $driver.'.default';

		list($type, $name) = explode('.', $driver, 2);

		if ( ! isset($this->instances[$driver]))
		{
			if (isset($this->registrar[$type]))
			{
				$resolver = $this->registrar[$type];

				return $this->instances[$driver] = $resolver($type, $config);
			}

			switch ($type)
			{
				case 'menu' :
					$this->instances[$driver] = new Menu($name, $config);
					break;
				case 'pane' :
					$this->instances[$driver] = new Pane($name, $config);
					break;
				case 'placeholder' :
					$this->instances[$driver] = new Placeholder($name, $config);
					break;
				default :
					throw new InvalidArgumentException(
						"Requested Orchestra\Widget Driver [{$type}] does not exist."
					);
			}
		}

		return $this->instances[$driver];
	}

	/**
	 * Register a third-party Widget driver.
	 * 
	 * @param  string   $driver
	 * @param  Closure  $resolver
	 * @return void
	 */
	public function extend($driver, Closure $resolver)
	{
		$this->registrar[$driver] = $resolver;
	}
}