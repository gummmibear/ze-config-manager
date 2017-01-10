<?php

require '../../vendor/autoload.php';

use Zend\Expressive\Config\ConfigManager;
use Zend\Expressive\Config\ConfigFileProviderFactory;
use Zend\Expressive\Config\ConfigFileProviderManager;

$configFileProviderFactory = new ConfigFileProviderFactory(__DIR__ . '/autoload/');
$configFileProviderManager = new ConfigFileProviderManager($configFileProviderFactory);

$routingFileProviderFactory = new ConfigFileProviderFactory(__DIR__ . '/routing/');
$routingFileProviderManager = new ConfigFileProviderManager($routingFileProviderFactory);

$configProviders = $configFileProviderManager->createDefaultProviders();
$routingProviders = $routingFileProviderManager->createDefaultProviders();

$providers = array_merge($configProviders, $routingProviders);

$configManager = new ConfigManager(__DIR__);
$configManager->registerProviders($providers);

$config = $configManager->getConfig();

var_dump($config);
