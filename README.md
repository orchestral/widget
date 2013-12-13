Orchestra Platform Widget Component
==============

`Orchestra\Widget` allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://poser.pugx.org/orchestra/widget/v/stable.png)](https://packagist.org/packages/orchestra/widget) 
[![Total Downloads](https://poser.pugx.org/orchestra/widget/downloads.png)](https://packagist.org/packages/orchestra/widget) 
[![Build Status](https://travis-ci.org/orchestral/widget.png?branch=2.1)](https://travis-ci.org/orchestral/widget) 
[![Coverage Status](https://coveralls.io/repos/orchestral/widget/badge.png?branch=2.1)](https://coveralls.io/r/orchestral/widget?branch=2.1) 
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/orchestral/widget/badges/quality-score.png?s=c45e8b240b7aedd08eaf70a0061c2b1d25c04f09)](https://scrutinizer-ci.com/g/orchestral/widget/) 

## Quick Installation

To install through composer, simply put the following in your `composer.json` file:

```json
{
	"require": {
		"orchestra/widget": "2.1.*@dev"
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
* [Change Log](http://orchestraplatform.com/docs/latest/components/widget/changes#v2-1)
