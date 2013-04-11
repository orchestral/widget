<?php namespace Orchestra\Widget\Drivers;

use Closure;

class Pane extends Driver {

	/**
	 * Type of Widget.
	 * 
	 * @var string
	 */
	protected $type = 'pane';

	/**
	 * Widget Configuration.
	 * 
	 * @var array
	 */
	protected $config = array(
		'defaults' => array(
			'attributes' => array(),
			'title'      => '',
			'content'    => '',
			'html'       => '',
		),
	);

	/**
	 * Add an item to current widget.
	 *
	 * @access public
	 * @param  string   $id
	 * @param  mixed    $location
	 * @param  Closure  $callback
	 * @return mixed
	 */
	public function add($id, $location = 'parent', $callback = null)
	{
		if ($location instanceof Closure)
		{
			$callback = $location;
			$location = 'parent';
		}

		if (starts_with($location, 'child')) $location = 'parent';

		$item = $this->nesty->add($id, $location ?: 'parent');

		if ($callback instanceof Closure)
		{
			call_user_func($callback, $item);
		}

		return $item;
	}
}