# Zend Expressive Config Manager

Library for config PHP application.

YAML, PHP 

with simple caching

Designed for zend-expressive.



```php

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
$configManager->registerProviders($configFileProviderManager->createDefaultProviders());
$configManager->registerProviders($routingFileProviderManager->createDefaultProviders());
$config = $configManager->getConfig();

var_dump($config);

```
