[![PHP](https://img.shields.io/badge/PHP-7.0%2B-blue.svg)](https://secure.php.net/migration70)
[![Latest Stable Version](https://poser.pugx.org/webinarium/datatables-bundle/v/stable)](https://packagist.org/packages/webinarium/datatables-bundle)
[![Build Status](https://travis-ci.org/webinarium/DataTablesBundle.svg?branch=master)](https://travis-ci.org/webinarium/DataTablesBundle)
[![Code Coverage](https://scrutinizer-ci.com/g/webinarium/DataTablesBundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/webinarium/DataTablesBundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/webinarium/DataTablesBundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/webinarium/DataTablesBundle/?branch=master)
[![SensioLabsInsight](https://insight.sensiolabs.com/projects/a53d13b5-1a56-4eb1-b724-3635bbfaa85d/mini.png)](https://insight.sensiolabs.com/projects/a53d13b5-1a56-4eb1-b724-3635bbfaa85d)

# DataTables Symfony bundle

This bundle helps to implement data source actions for [DataTables](http://www.datatables.net/) JavaScript plugin when it's used in [server-side processing](http://www.datatables.net/manual/server-side) mode.

## Requirements

PHP needs to be a minimum version of PHP 7.0.

Symfony must be of 2.8 or above.

## Installation

The recommended way to install is via Composer:

```bash
composer require "webinarium/datatables-bundle"
```

Then, add the following line in the `app/AppKernel.php` file to enable this bundle:

```php
public function registerBundles()
{
    $bundles = [
        // ...
        new DataTables\DataTablesBundle(),
    ];
}
```

## Development

```bash
phpunit --coverage-html=vendor/coverage
./bin/php-cs-fixer fix
```

## Usage

Please see the complete usage example [here](../../wiki/Example).
