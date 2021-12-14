<a href="https://aimeos.org/">
    <img src="https://aimeos.org/fileadmin/template/icons/logo.png" alt="Aimeos logo" title="Aimeos" align="right" height="60" />
</a>

# Aimeos Monolog adapter

[![Build Status](https://circleci.com/gh/aimeos/ai-monolog.svg?style=shield)](https://circleci.com/gh/aimeos/ai-monolog)
[![Coverage Status](https://coveralls.io/repos/aimeos/ai-monolog/badge.svg?branch=master)](https://coveralls.io/r/aimeos/ai-monolog?branch=master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/aimeos/ai-monolog/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/aimeos/ai-monolog/?branch=master)
[![License](https://poser.pugx.org/aimeos/ai-monolog/license.svg)](https://packagist.org/packages/aimeos/ai-monolog)

The Aimeos ecommerce components can integrate into almost any PHP application and uses the infrastructure of the application for building URLs, caching content, configuration settings, logging messages, session handling, sending e-mails or handling translations.

The ai-monolog extension integrates the PHP Monolog library for logging messages into Aimeos. It's useful if your application already uses Monolog for logging and offers access to a Monolog object that can be used together with this extension.

## Table of content

- [Installation](#installation)
- [Setup](#setup)
- [License](#license)
- [Links](#links)

## Installation

To allow the Aimeos ecommerce components accessing the log infrastructure of your own framework or application, you have to install the adapter first. As every Aimeos extension, the easiest way is to install it via [composer](https://getcomposer.org/). If you don't have composer installed yet, you can execute this string on the command line to download it:

```bash
php -r "readfile('https://getcomposer.org/installer');" | php -- --filename=composer
```

Install the Monolog adapter using:

```bash
composer req aimeos/ai-monolog
```

## Setup

Now add the Monolog object to the Aimeos context, which you have to create to get the Aimeos components running:
```
// $logger is a Monolog instance
$log = new \Aimeos\MW\Logger\Monolog( $logger );
$context->setLogger( $log );
```

## License

The Aimeos ai-monolog extension is licensed under the terms of the LGPLv3 license and is available for free.

## Links

* [Web site](https://aimeos.org/)
* [Documentation](https://aimeos.org/docs)
* [Help](https://aimeos.org/help)
* [Issue tracker](https://github.com/aimeos/ai-monolog/issues)
* [Source code](https://github.com/aimeos/ai-monolog)
