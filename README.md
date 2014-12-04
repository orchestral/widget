Orchestra Platform Widget Component
==============

`Orchestra\Widget` allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://img.shields.io/github/release/orchestral/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://img.shields.io/packagist/dt/orchestra/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![MIT License](https://img.shields.io/packagist/l/orchestra/widget.svg?style=flat)](https://packagist.org/packages/orchestra/widget)
[![Build Status](https://img.shields.io/travis/orchestral/widget/master.svg?style=flat)](https://travis-ci.org/orchestral/widget)
[![Coverage Status](https://img.shields.io/coveralls/orchestral/widget/master.svg?style=flat)](https://coveralls.io/r/orchestral/widget?branch=master)
[![Scrutinizer Quality Score](https://img.shields.io/scrutinizer/g/orchestral/widget/master.svg?style=flat)](https://scrutinizer-ci.com/g/orchestral/widget/)

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"orchestra/widget": "3.0.*"
	}
}
```

Next add the service provider in `app/config/app.php`.

```php
'providers' => array(

	// ...

	'Orchestra\Widget\WidgetServiceProvider',
),
```

## Resources

* [Documentation](http://orchestraplatform.com/docs/latest/components/widget)
* [Change Log](http://orchestraplatform.com/docs/latest/components/widget/changes#v3-0)
