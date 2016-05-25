Widget Component for Orchestra Platform
==============

[![Join the chat at https://gitter.im/orchestral/platform](https://badges.gitter.im/Join%20Chat.svg)](https://gitter.im/orchestral/platform?utm_source=badge&utm_medium=badge&utm_campaign=pr-badge&utm_content=badge)

Widget Component allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://img.shields.io/github/release/orchestral/widget.svg?style=flat-square)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestra/widget.svg?style=flat-square)](https://packagist.org/packages/orchestra/widget)
[![MIT License](https://img.shields.io/packagist/l/orchestra/widget.svg?style=flat-square)](https://packagist.org/packages/orchestra/widget)
[![Build Status](https://img.shields.io/travis/orchestral/widget/master.svg?style=flat-square)](https://travis-ci.org/orchestral/widget)
[![Coverage Status](https://img.shields.io/coveralls/orchestral/widget/master.svg?style=flat-square)](https://coveralls.io/r/orchestral/widget?branch=master)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/orchestral/widget/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/orchestral/widget/)

## Table of Content

* [Version Compatibility](#version-compatibility)
* [Installation](#installation)
* [Configuration](#configuration)
* [Resources](#resources)
* [Change Log](http://orchestraplatform.com/docs/latest/components/widget/changes#v3-4)

## Version Compatibility

Laravel    | Widget
:----------|:----------
 4.0.x     | 2.0.x
 4.1.x     | 2.1.x
 4.2.x     | 2.2.x
 5.0.x     | 3.0.x
 5.1.x     | 3.1.x
 5.2.x     | 3.2.x
 5.3.x     | 3.3.x@dev

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

## Resources

* [Documentation](http://orchestraplatform.com/docs/latest/components/widget)
