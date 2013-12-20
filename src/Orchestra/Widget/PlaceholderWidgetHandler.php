<?php namespace Orchestra\Widget;

use Closure;

class PlaceholderWidgetHandler extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'placeholder';

    /**
     * {@inheritdoc}
     */
    protected $config = array(
        'defaults' => array(
            'value' => '',
        ),
    );

    /**
     * {@inheritdoc}
     */
    public function add($id, $location = '#', $callback = null)
    {
        if (is_string($location) and starts_with($location, '^:')) {
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
