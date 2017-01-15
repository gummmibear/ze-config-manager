<?php

namespace Zend\Expressive\Config\Provider;

use Symfony\Component\Yaml\Yaml;
use Zend\Stdlib\ArrayUtils;

class YamlFileProvider extends FileProvider
{
    protected function getConfigFromFile(array $config, string $file) : array
    {
        return ArrayUtils::merge($config, Yaml::parse(file_get_contents($file)));
    }
}