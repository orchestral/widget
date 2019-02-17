<?php

namespace Orchestra\Widget\Handlers;

use Illuminate\Support\Str;
use Orchestra\Widget\Handler;

class Dash extends Handler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'dash';

    /**
     * {@inheritdoc}
     */
    protected $config = [
        'defaults' => [
            'icon' => '',
            'color' => '',
            'prefix' => '',
            'suffix' => '',
            'title' => '',
            'value' => 0,
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
