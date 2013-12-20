<?php namespace Orchestra\Widget;

class PaneWidgetHandler extends Factory
{
    /**
     * {@inheritdoc}
     */
    protected $type = 'pane';

    /**
     * {@inheritdoc}
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
     * {@inheritdoc}
     */
    public function add($id, $location = '#', $callback = null)
    {
        if (is_string($location) and starts_with($location, '^:')) {
            $location = '#';
        }

        return $this->addItem($id, $location, $callback);
    }
}
