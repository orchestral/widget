<?php namespace Orchestra\Widget;

use Closure;
use Orchestra\Support\Str;

class PlaceholderWidgetHandler extends Factory
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
    public function add($id, $location = '#', $callback = null)
    {
        if (is_string($location) && Str::startsWith($location, '^:')) {
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
