<?php

namespace Orchestra\Widget\Fluent;

use Illuminate\Support\Fluent;
use Orchestra\Support\Facades\Foundation;

class Menu extends Fluent
{
    /**
     * Is currently active.
     *
     * @return bool
     */
    public function active()
    {
        return Foundation::is($this->get('handles').'*');
    }

    /**
     * Has link.
     *
     * @return bool
     */
    public function hasLink()
    {
        $link = $this->get('link');

        return ! (empty($link) || $link == '#');
    }
}
