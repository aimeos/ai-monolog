<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Monolog adapter

[![Build Status](https://travis-ci.org/aimeos/ai-monolog.svg)](https://travis-ci.org/aimeos/ai-monolog)
[![Coverage Status](https://coveralls.io/repos/aimeos/ai-monolog/badge.svg?branch=master)](https://coveralls.io/r/aimeos/ai-monolog?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/ai-monolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/ai-monolog/?branch=master)
[![HHVM Status](http://hhvm.h4cc.de/badge/aimeos/ai-monolog.svg)](http://hhvm.h4cc.de/package/aimeos/ai-monolog)

The Aimeos web shop components can integrate into almost any PHP application and uses the infrastructure of the application for building URLs, caching content, configuration settings, logging messages, session handling, sending e-mails or handling translations.

The ai-monolog extension integrates the PHP Monolog library for logging messages into Aimeos. It's useful if your application already uses Monolog for logging and offers access to a Monolog object that can be used together with this extension.

## Table of content

- [Installation](#installation)
- [Setup](#setup)
- [License](#license)
- [Links](#links)

## Installation

To allow the Aimeos web shop components accessing the log infrastructure of your own framework or application, you have to install the adapter first. As every Aimeos extension, the easiest way is to install it via [composer](https://getcomposer.org/). If you don't have composer installed yet, you can execute this string on the command line to download it:
```
php -r "readfile('https://getcomposer.org/installer');" | php -- --filename=composer
```

Add the ai-monolog extension to the "require" section of your ```composer.json``` file:
```
"require": [
    "aimeos/ai-monolog": "dev-master",
    ...
],
```
If you don't want to use the latest version, you can also install any release. The list of releases is available at [Packagist](https://packagist.org/packages/aimeos/ai-monolog). Afterwards you only need to execute the composer update command on the command line:
```
composer update
```

## Setup

Now add the Monolog object to the Aimeos context, which you have to create to get the Aimeos components running:
```
// $logger is a Monolog instance
$log = new MW_Logger_Monolog( $logger );
$context->setLogger( $log );
```

## License

The Aimeos ai-swiftmailer extension is licensed under the terms of the LGPLv3 license and is available for free.

## Links

* [Web site](https://aimeos.org/)
* [Documentation](https://aimeos.org/docs)
* [Help](https://aimeos.org/help)
* [Issue tracker](https://github.com/aimeos/ai-monolog/issues)
* [Source code](https://github.com/aimeos/ai-monolog)
