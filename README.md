Orchestra Platform Widget Component
==============

`Orchestra\Widget` allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![Latest Stable Version](https://poser.pugx.org/orchestra/widget/v/stable.png)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://poser.pugx.org/orchestra/widget/downloads.png)](https://packagist.org/packages/orchestra/widget)
[![Build Status](https://travis-ci.org/orchestral/widget.svg?branch=master)](https://travis-ci.org/orchestral/widget)
[![Coverage Status](https://coveralls.io/repos/orchestral/widget/badge.png?branch=master)](https://coveralls.io/r/orchestral/widget?branch=master)
[![Scrutinizer Quality Score](https://scrutinizer-ci.com/g/orchestral/widget/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/orchestral/widget/)

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
