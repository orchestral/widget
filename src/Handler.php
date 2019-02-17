<?php

namespace Orchestra\Widget;

use Closure;
use Countable;
use IteratorAggregate;
use Orchestra\Support\Nesty;
use Orchestra\Support\Fluent;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Support\Jsonable;

abstract class Handler implements Countable, IteratorAggregate, Jsonable
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
    protected $config = [];

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
    public function __construct(string $name, array $config = [])
    {
        $this->config = \array_merge($config, $this->config);

        $this->name = $name;
        $this->nesty = new Nesty($this->config);
    }

    /**
     * Add an item to current widget.
     *
     * @param  string  $id
     * @param  string|\Closure  $location
     * @param  \Closure|null  $callback
     *
     * @return mixed
     */
    abstract public function add(string $id, $location = 'parent', $callback = null);

    /**
     * Attach item to current widget.
     *
     * @param  string  $id
     * @param  string|\Closure  $location
     * @param  \Closure|null  $callback
     *
     *  @return mixed
     */
    protected function addItem(string $id, $location = 'parent', $callback = null): ?Fluent
    {
        if ($location instanceof Closure) {
            $callback = $location;
            $location = 'parent';
        }

        $item = $this->nesty->add($id, $location ?: 'parent');

        if ($callback instanceof Closure) {
            $callback($item);
        }

        return $item;
    }

    /**
     * Get an instance of item from current widget.
     *
     * @param  string  $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return $this->nesty->has($id);
    }

    /**
     * Get if the instance has an item.
     *
     * @param  string|null  $id
     *
     * @return mixed
     */
    public function is(?string $id)
    {
        return $this->nesty->is($id);
    }

    /**
     * Get all item from Nesty.
     *
     * @return \Orchestra\Support\Collection
     */
    public function items(): Collection
    {
        return $this->nesty->items();
    }

    /**
     * Convert the object to its JSON representation.
     *
     * @param  int  $options
     *
     * @return string
     */
    public function toJson($options = 0)
    {
        return $this->items()->toJson($options);
    }

    /**
     * Get the number of items.
     *
     * @return int
     */
    public function count(): int
    {
        return $this->items()->count();
    }

    /**
     * Determine if the items is empty or not.
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return $this->items()->isEmpty();
    }

    /**
     * Get an iterator for the items.
     *
     * @return \Orchestra\Support\Collection
     */
    public function getIterator(): Collection
    {
        return $this->items();
    }
}
