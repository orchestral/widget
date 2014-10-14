<?php namespace Orchestra\Widget;

use Orchestra\Support\Str;

class PaneWidgetHandler extends Factory
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
            'title'      => '',
            'content'    => '',
            'html'       => '',
        ],
    ];

    /**
     * {@inheritdoc}
     */
    public function add($id, $location = '#', $callback = null)
    {
        if (is_string($location) && Str::startsWith($location, '^:')) {
            $location = '#';
        }

        return $this->addItem($id, $location, $callback);
    }
}
