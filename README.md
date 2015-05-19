Widget Component for Orchestra Platform
==============

Widget Component allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://img.shields.io/github/release/orchestral/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestra/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![MIT License](https://img.shields.io/packagist/l/orchestra/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![Build Status](https://img.shields.io/travis/orchestral/widget/3.0.svg?style=flat)](https://travis-ci.org/orchestral/widget)
[![Coverage Status](https://img.shields.io/coveralls/orchestral/widget/3.0.svg?style=flat)](https://coveralls.io/r/orchestral/widget?branch=3.0)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/orchestral/widget/3.0.svg?style=flat)](https://scrutinizer-ci.com/g/orchestral/widget/)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Resources](#resources)

## Version Compatibility

Laravel    | Widget
:----------|:----------
 4.0.x     | 2.0.x
 4.1.x     | 2.1.x
 4.2.x     | 2.2.x
 5.0.x     | 3.0.x

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

	'Orchestra\Widget\WidgetServiceProvider',
],
```

## Resources

* [Documentation](http://orchestraplatform.com/docs/latest/components/widget)
* [Change Log](http://orchestraplatform.com/docs/latest/components/widget/changes#v3-0)
