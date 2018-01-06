<?php

namespace Orchestra\Widget\Fluent;

use Orchestra\Support\Fluent;
use Orchestra\Support\Facades\Foundation;

class Menu extends Fluent
{
    /**
     * Is currently active.
     *
     * @return bool
     */
    public function active(): bool
    {
        return Foundation::is($this->get('handles').'*');
    }

    /**
     * Has link.
     *
     * @return bool
     */
    public function hasLink(): bool
    {
        $link = $this->get('link');

        return ! (empty($link) || $link == '#');
    }
}
