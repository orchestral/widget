<?php

namespace Orchestra\Widget\Handlers;

use Orchestra\Widget\Fluent\Menu as Fluent;
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
        'fluent' => Fluent::class,
        'defaults' => [
            'icon' => '',
            'link' => '#',
            'title' => '',
            'handles' => null,
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function add(string $id, $location = '#', $callback = null)
    {
        return $this->addItem($id, $location, $callback);
    }
}
