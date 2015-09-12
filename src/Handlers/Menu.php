<?php namespace Orchestra\Widget\Handlers;

use Orchestra\Widget\Handler;

class Menu extends Handler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'menu';

    /**
     * {@inheritdoc}
     */
    protected $config = [
        'defaults' => [
            'attributes' => [],
            'icon'       => '',
            'link'       => '#',
            'title'      => '',
            'handles'    => null,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function add($id, $location = '#', $callback = null)
    {
        return $this->addItem($id, $location, $callback);
    }
}
