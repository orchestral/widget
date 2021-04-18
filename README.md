Widget Component for Orchestra Platform
==============

Widget Component allow you to manage widgetize actions in Orchestra Platform. By default Orchestra Platform provides the following widgets:

* **Menu** to manage menu.
* **Pane** to manage dashboard items.
* **Placeholder** to manage sidebar widgets.

[![tests](https://github.com/orchestral/widget/workflows/tests/badge.svg?branch=6.x)](https://github.com/orchestral/widget/actions?query=workflow%3Atests+branch%3A6.x)
[![Latest Stable Version](https://poser.pugx.org/orchestra/widget/version)](https://packagist.org/packages/orchestra/widget)
[![Total Downloads](https://poser.pugx.org/orchestra/widget/downloads)](https://packagist.org/packages/orchestra/widget)
[![Latest Unstable Version](https://poser.pugx.org/orchestra/widget/v/unstable)](//packagist.org/packages/orchestra/widget)
[![License](https://poser.pugx.org/orchestra/widget/license)](https://packagist.org/packages/orchestra/widget)
[![Coverage Status](https://coveralls.io/repos/github/orchestral/widget/badge.svg?branch=6.x)](https://coveralls.io/github/orchestral/widget?branch=6.x)

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
 7.x       | 5.x
 8.x       | 6.x

## Installation

To install through composer, run the following command from terminal:

```bash
composer require "orchestra/widget"
```

## Configuration

Add following service providers in `config/app.php`.

```php
'providers' => [

    // ...

    Orchestra\Widget\WidgetServiceProvider::class,
],
```

