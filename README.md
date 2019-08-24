Widget Component for Orchestra Platform
==============

Widget Component allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Build Status](https://travis-ci.org/orchestral/widget.svg?branch=4.x)](https://travis-ci.org/orchestral/widget)
[![Latest Stable Version](https://poser.pugx.org/orchestra/widget/version)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://poser.pugx.org/orchestra/widget/downloads)](https://packagist.org/packages/orchestra/widget)
[![Latest Unstable Version](https://poser.pugx.org/orchestra/widget/v/unstable)](//packagist.org/packages/orchestra/widget)
[![License](https://poser.pugx.org/orchestra/widget/license)](https://packagist.org/packages/orchestra/widget)
[![Coverage Status](https://coveralls.io/repos/github/orchestral/widget/badge.svg?branch=master)](https://coveralls.io/github/orchestral/widget?branch=master)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Changelog](https://github.com/orchestral/widget/releases)

## Version Compatibility

Laravel    | Widget
:----------|:----------
 5.5.x     | 3.5.x
 5.6.x     | 3.6.x
 5.7.x     | 3.7.x
 5.8.x     | 3.8.x
 6.x       | 4.x

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "orchestra/widget": "^4.0"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "orchestra/widget=^4.0"

## Configuration

Add following service providers in `config/app.php`.

```php
'providers' => [

    // ...

    Orchestra\Widget\WidgetServiceProvider::class,
],
```

