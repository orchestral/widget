<?php namespace Orchestra\Widget\Drivers;

use Closure;
use Countable;
use ArrayIterator;
use IteratorAggregate;
use InvalidArgumentException;
use Illuminate\Container\Container;
use Orchestra\Support\Nesty;

abstract class Driver implements Countable, IteratorAggregate
{
    /**
     * Application instance.
     *
     * @var \Illuminate\Container\Container
     */
    protected $app = null;

    /**
     * Nesty instance.
     *
     * @var \Orchestra\Support\Nesty
     */
    protected $nesty = null;

    /**
     * Name of this instance.
     *
     * @var string
     */
    protected $name = null;

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
    protected $type = null;

    /**
     * Construct a new instance.
     *
     * @param  \Illuminate\Container\Container  $app
     * @param  string                           $name
     */
    public function __construct(Container $app, $name)
    {
        $this->app    = $app;
        $this->config = array_merge(
            $this->app['config']->get("orchestra/widget::{$this->type}.{$name}", array()),
            $this->config
        );

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
     * Magic method to get all items.
     *
     * @param  string   $key
     * @return mixed
     * @throws \InvalidArgumentException
     */
    public function __get($key)
    {
        if ($key !== 'items') {
            throw new InvalidArgumentException("Access to [{$key}] is not allowed.");
        }

        return $this->getItems();
    }

    /**
     * Get the number of items for the current page.
     *
     * @return integer
     */
    public function count()
    {
        return count($this->nesty->getItems());
    }

    /**
     * Get an iterator for the items.
     *
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return new ArrayIterator($this->nesty->getItems());
    }
}
