Orchestra Platform Widget Component
==============

Orchestra\Widget allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Build Status](https://travis-ci.org/orchestral/widget.png?branch=master)](https://travis-ci.org/orchestral/widget)

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"orchestra/widget": "2.0.*"
	},
	"minimum-stability": "dev"
}
```

Next add the service provider in `app/config/app.php`.

```php
'providers' => array(
	
	// ...
	
	'Orchestra\Widget\PackageServiceProvider',
	'Orchestra\Widget\WidgetServiceProvider',
),
```

You might want to add `Orchestra\Widget` to class aliases in `app/config/app.php`:

```php
'aliases' => array(

	// ...

	'Orchestra\Widget' => 'Orchestra\Support\Facades\Widget',
),
```

## Resources

* [Documentation](http://docs.orchestraplatform.com/pages/components/widget)
* [Change Logs](https://github.com/orchestral/widget/wiki/Change-Logs)
