<?php namespace Orchestra\Widget\Drivers;

use Closure;

class Placeholder extends Driver {

	/**
	 * Type of widget.
	 * 
	 * @var string
	 */
	protected $type = 'placeholder';

	/**
	 * Widget configuration.
	 * 
	 * @var array
	 */
	protected $config = array(
		'defaults' => array(
			'value' => '',
		),
	);

	/**
	 * Add an item to current widget.
	 *
	 * @param  string   $id
	 * @param  mixed    $location
	 * @param  \Closure $callback
	 * @return mixed
	 */
	public function add($id, $location = '#', $callback = null)
	{
		if (is_string($location) and starts_with($location, '^:')) 
		{
			$location = '#';
		}
		elseif ($location instanceof Closure)
		{
			$callback = $location;
			$location = '#';
		}

		$item = $this->nesty->add($id, $location ?: '#');

		if ($callback instanceof Closure)
		{
			$item->value = $callback;
		}

		return $item;
	}
}
