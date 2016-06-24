<?php

return [

    /*
    |----------------------------------------------------------------------
    | Default Drivr
    |----------------------------------------------------------------------
    |
    | Set default driver for Orchestra\Widget.
    |
    */

    'default' => 'placeholder.default',

    /*
    |----------------------------------------------------------------------
    | Dash Configuration
    |----------------------------------------------------------------------
    */

    'dash' => [
        'defaults' => [
            'icon'   => '',
            'color'  => '',
            'prefix' => '',
            'suffix' => '',
            'title'  => '',
            'value'  => 0,
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Menu Configuration
    |----------------------------------------------------------------------
    */

    'menu' => [
        'defaults' => [
            'attributes' => [],
            'icon'       => '',
            'link'       => '#',
            'title'      => '',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Pane Configuration
    |----------------------------------------------------------------------
    */

    'pane' => [
        'defaults' => [
            'attributes' => [],
            'title'      => '',
            'content'    => '',
            'html'       => '',
        ],
    ],

    /*
    |----------------------------------------------------------------------
    | Placeholder Configuration
    |----------------------------------------------------------------------
    */

    'placeholder' => [
        'defaults' => [
            'value' => '',
        ],
    ],
];
