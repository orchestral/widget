<?php namespace Orchestra\Widget;

class MenuWidgetHandler extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'menu';

    /**
     * {@inheritdoc}
     */
    protected $config = array(
        'defaults' => array(
            'attributes' => array(),
            'icon'       => '',
            'link'       => '#',
            'title'      => '',
        ),
    );

    /**
     * {@inheritdoc}
     */
    public function add($id, $location = '#', $callback = null)
    {
        return $this->addItem($id, $location, $callback);
    }
}
