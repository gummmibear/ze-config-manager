# Zend Expressive Config Manager

   [![Build Status](https://travis-ci.org/gummmibear/ze-config-manager.svg?branch=master)](https://travis-ci.org/gummmibear/ze-config-manager)
   
Library for config PHP application.
With simple caching.

Designed for [zend-expressive](https://zendframework.github.io/zend-expressive/)
   
## Installation

### Composer

The preferred way to install this extension is through [Composer](http://getcomposer.org/).

Either run

```
composer require gummmibear/ze-config-manager dev-master
```

or add

```
"gummmibear/ze-config-manager": "dev-master"
```

to the require section of your ```composer.json```


## Usage

### Config providers

- PHP
- Yaml

File name patterns for php files. 
 - *.global.php
 - *.local.php
 
File name patterns for Yaml files
 - *.yml, 
 - *.global.yml
 - *.local.yml

To cache config file you can set cache dir otherwise will be used default value for cache file. 

```php

//config/config.php
<?php

require '../../vendor/autoload.php';

use Zend\Expressive\Config\ConfigManager;
use Zend\Expressive\Config\ConfigFileProviderFactory;
use Zend\Expressive\Config\ConfigFileProviderManager;

$configFileProviderFactory = new ConfigFileProviderFactory(__DIR__ . '/autoload/');
$configFileProviderManager = new ConfigFileProviderManager($configFileProviderFactory);

$routingFileProviderFactory = new ConfigFileProviderFactory(__DIR__ . '/routing/');
$routingFileProviderManager = new ConfigFileProviderManager($routingFileProviderFactory);

$configManager = new ConfigManager(__DIR__);
$configManager->setCacheFile('/cache/config_cache.php');
$configManager->registerProviders($configFileProviderManager->createDefaultProviders());
$configManager->registerProviders($routingFileProviderManager->createDefaultProviders());
$config = $configManager->getConfig();

return new ArrayObject($config, ArrayObject::ARRAY_AS_PROPS);
```

See Example/config.php.
