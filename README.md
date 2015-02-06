Orchestra Platform Widget Component
==============

`Orchestra\Widget` allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://img.shields.io/github/release/orchestral/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestra/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![MIT License](https://img.shields.io/packagist/l/orchestra/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![Build Status](https://img.shields.io/travis/orchestral/widget/2.0.svg?style=flat)](https://travis-ci.org/orchestral/widget)
[![Coverage Status](https://img.shields.io/coveralls/orchestral/widget/2.0.svg?style=flat)](https://coveralls.io/r/orchestral/widget?branch=2.0)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/orchestral/widget/2.0.svg?style=flat)](https://scrutinizer-ci.com/g/orchestral/widget/)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Resources](#resources)

## Version Compatibility

Laravel    | Widget
:----------|:----------
 4.0.x     | 2.0.x

## Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
    "require": {
        "orchestra/widget": "2.0.*"
    }
}
```

And then run `composer install` from the terminal.

### Quick Installation

Above installation can also be simplify by using the following command:

    composer require "orchestra/widget=2.0.*"

## Configuration

Add following service providers in `app/config/app.php`.

```php
'providers' => array(

	// ...

	'Orchestra\Widget\WidgetServiceProvider',
),
```

## Resources

* [Documentation](http://orchestraplatform.com/docs/2.0/components/widget)
* [Change Log](http://orchestraplatform.com/docs/2.0/components/widget/changes#v2.0)
