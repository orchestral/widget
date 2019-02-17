<?php

namespace Orchestra\Widget\Handlers;

use Orchestra\Support\Str;
use Orchestra\Widget\Handler;

class Pane extends Handler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'pane';

    /**
     * {@inheritdoc}
     */
    protected $config = [
        'defaults' => [
            'attributes' => [],
            'title' => '',
            'content' => '',
            'html' => '',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function add(string $id, $location = '#', $callback = null)
    {
        if (\is_string($location) && Str::startsWith($location, '^:')) {
            $location = '#';
        }

        return $this->addItem($id, $location, $callback);
    }
}
