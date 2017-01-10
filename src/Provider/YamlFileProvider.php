<?php

namespace Zend\Expressive\Config\Provider;

use Symfony\Component\Yaml\Yaml;

class YamlFileProvider extends FileProvider
{
    use ArrayUtilTrait;

    protected function getConfigFromFile(array $config, \SplFileInfo $file) : array
    {
        return self::merge($config, Yaml::parse(file_get_contents($file->getRealPath())));
    }
}