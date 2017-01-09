<?php

namespace Zend\Expressive\Config\Provider;

use Symfony\Component\Yaml\Yaml;
use Zend\Stdlib\ArrayUtils;

class YamlFileProvider extends FileProvider
{
    public function getConfigFromFile(array $config, \SplFileInfo $file) : array
    {
        return ArrayUtils::merge($config, Yaml::parse(file_get_contents($file->getRealPath())));
    }
}