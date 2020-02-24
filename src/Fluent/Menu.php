<?php

namespace Orchestra\Widget\Fluent;

use Orchestra\Support\Facades\Foundation;
use Orchestra\Support\Fluent;

class Menu extends Fluent
{
    /**
     * Is currently active.
     */
    public function active(): bool
    {
        return Foundation::is($this->get('handles').'*');
    }

    /**
     * Has link.
     */
    public function hasLink(): bool
    {
        $link = $this->get('link');

        return ! (empty($link) || $link == '#');
    }
}
