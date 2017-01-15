<?php

namespace Zend\Expressive\Config\Provider;

use Zend\Stdlib\ArrayUtils;

class PhpFileProvider extends FileProvider
{
    protected function getConfigFromFile(array $config, string $file) : array
    {
        return ArrayUtils::merge($config, include  $file);
    }
}