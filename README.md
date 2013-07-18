Orchestra Platform Widget Component
==============

Orchestra\Widget allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://poser.pugx.org/orchestra/widget/v/stable.png)](https://packagist.org/packages/orchestra/widget) 
[![Total Downloads](https://poser.pugx.org/orchestra/widget/downloads.png)](https://packagist.org/packages/orchestra/widget) 
[![Build Status](https://travis-ci.org/orchestral/widget.png?branch=2.0)](https://travis-ci.org/orchestral/widget) 
[![Coverage Status](https://coveralls.io/repos/orchestral/widget/badge.png?branch=2.0)](https://coveralls.io/r/orchestral/widget?branch=2.0)

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"orchestra/widget": "2.0.*"
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

* [Documentation](http://orchestraplatform.com/docs/2.0/components/widget)
* [Change Log](http://orchestraplatform.com/docs/2.0/components/widget/changes#v2.0)
