Widget Component for Orchestra Platform
==============

Widget Component allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Build Status](https://travis-ci.org/orchestral/widget.svg?branch=3.6)](https://travis-ci.org/orchestral/widget)
[![Latest Stable Version](https://poser.pugx.org/orchestra/widget/version)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://poser.pugx.org/orchestra/widget/downloads)](https://packagist.org/packages/orchestra/widget)
[![Latest Unstable Version](https://poser.pugx.org/orchestra/widget/v/unstable)](//packagist.org/packages/orchestra/widget)
[![License](https://poser.pugx.org/orchestra/widget/license)](https://packagist.org/packages/orchestra/widget)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Changelog](https://github.com/orchestral/widget/releases)

## Version Compatibility

Laravel    | Widget
:----------|:----------
 4.x.x     | 2.x.x
 5.0.x     | 3.0.x
 5.1.x     | 3.1.x
 5.2.x     | 3.2.x
 5.3.x     | 3.3.x
 5.4.x     | 3.4.x
 5.5.x     | 3.5.x
 5.6.x     | 3.6.x

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "orchestra/widget": "~3.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "orchestra/widget=~3.0"

## Configuration

Add following service providers in `config/app.php`.

```php
'providers' => [

    // ...

    Orchestra\Widget\WidgetServiceProvider::class,
],
```

