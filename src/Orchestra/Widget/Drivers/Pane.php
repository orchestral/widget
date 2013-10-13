<?php namespace Orchestra\Widget\Drivers;

class Pane extends Driver {

	/**
	 * Type of widget.
	 * 
	 * @var string
	 */
	protected $type = 'pane';

	/**
	 * Widget configuration.
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

		return $this->addItem($id, $location, $callback);
	}
}
