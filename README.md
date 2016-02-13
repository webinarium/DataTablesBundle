[![License](https://poser.pugx.org/arodygin/datatables-bundle/license)](https://packagist.org/packages/arodygin/datatables-bundle)
[![Latest Stable Version](https://poser.pugx.org/arodygin/datatables-bundle/v/stable)](https://packagist.org/packages/arodygin/datatables-bundle)
[![Build Status](https://travis-ci.org/arodygin/datatables-bundle.svg?branch=master)](https://travis-ci.org/arodygin/datatables-bundle)
[![Code Coverage](https://scrutinizer-ci.com/g/arodygin/datatables-bundle/badges/coverage.png?b=master)](https://scrutinizer-ci.com/g/arodygin/datatables-bundle/?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/arodygin/datatables-bundle/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/arodygin/datatables-bundle/?branch=master)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/7eb4fffa-bcab-4252-b4f6-3bb069f2ba73.svg)](https://insight.sensiolabs.com/projects/7eb4fffa-bcab-4252-b4f6-3bb069f2ba73)

# DataTables Symfony bundle

This bundle helps to implement data source actions for [DataTables](http://www.datatables.net/) JavaScript plugin when it's used in [server-side processing](http://www.datatables.net/manual/server-side) mode.

## Requirements

PHP needs to be a minimum version of PHP 5.5.0.

## Installation

The recommended way to install is via Composer:

```bash
composer.phar require "arodygin/datatables-bundle"
composer.phar install
```

## Development

```bash
./bin/php-cs-fixer fix
./bin/phpunit --coverage-html=vendor/coverage
```

## Usage

Please see the complete usage example [here](../../wiki).
