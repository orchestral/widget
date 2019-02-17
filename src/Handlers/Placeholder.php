<?php

namespace Orchestra\Widget\Handlers;

use Closure;
use Orchestra\Support\Str;
use Orchestra\Widget\Handler;

class Placeholder extends Handler
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'placeholder';

    /**
     * {@inheritdoc}
     */
    protected $config = [
        'defaults' => [
            'value' => '',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function add(string $id, $location = '#', $callback = null)
    {
        if (\is_string($location) && Str::startsWith($location, '^:')) {
            $location = '#';
        } elseif ($location instanceof Closure) {
            $callback = $location;
            $location = '#';
        }

        $item = $this->nesty->add($id, $location ?: '#');

        if ($callback instanceof Closure) {
            $item->value = $callback;
        }

        return $item;
    }
}
