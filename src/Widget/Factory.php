<?php namespace Orchestra\Widget;

use Closure;
use Countable;
use IteratorAggregate;
use Orchestra\Support\Nesty;

abstract class Factory implements Countable, IteratorAggregate
{
    /**
     * Nesty instance.
     *
     * @var \Orchestra\Support\Nesty
     */
    protected $nesty;

    /**
     * Name of this instance.
     *
     * @var string
     */
    protected $name;

    /**
     * Widget configuration.
     *
     * @var array
     */
    protected $config = array();

    /**
     * Type of widget.
     *
     * @var string
     */
    protected $type;

    /**
     * Construct a new instance.
     *
     * @param  string  $name
     * @param  array   $config
     */
    public function __construct($name, array $config = array())
    {
        $this->config = array_merge($config, $this->config);

        $this->name  = $name;
        $this->nesty = new Nesty($this->config);
    }

    /**
     * Add an item to current widget.
     *
     * @param  string   $id
     * @param  mixed    $location
     * @param  \Closure $callback
     * @return mixed
     */
    abstract public function add($id, $location = 'parent', $callback = null);

    /**
     * Attach item to current widget.
     *
     * @param  string   $id
     * @param  mixed    $location
     * @param  \Closure $callback
     * @return mixed
     */
    protected function addItem($id, $location = 'parent', $callback = null)
    {
        if ($location instanceof Closure) {
            $callback = $location;
            $location = 'parent';
        }

        $item = $this->nesty->add($id, $location ?: 'parent');

        if ($callback instanceof Closure) {
            call_user_func($callback, $item);
        }

        return $item;
    }

    /**
     * Get an instance of item from current widget.
     *
     * @param  string   $id
     * @return mixed
     */
    public function is($id)
    {
        return $this->nesty->is($id);
    }

    /**
     * Get all item from Nesty.
     *
     * @return array
     * @see    \Orchestra\Support\Nesty::getItem()
     */
    public function getItems()
    {
        return $this->nesty->getItems();
    }

    /**
     * Get the number of items for the current page.
     *
     * @return integer
     */
    public function count()
    {
        return $this->nesty->getItems()->count();
    }

    /**
     * Get an iterator for the items.
     *
     * @return \Illuminate\Support\Collection
     */
    public function getIterator()
    {
        return $this->nesty->getItems();
    }
}