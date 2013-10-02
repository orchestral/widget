<?php namespace Orchestra\Widget\Drivers;

use Closure;

class Menu extends Driver {

	/**
	 * Type of widget.
	 * 
	 * @var string
	 */
	protected $type = 'menu';

	/**
	 * Widget configuration.
	 * 
	 * @var array
	 */
	protected $config = array(
		'defaults' => array(
			'title'      => '',
			'link'       => '#',
			'attributes' => array(),
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
		return $this->addItem($id, $location, $callback);
	}
}
