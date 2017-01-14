<?php

namespace Zend\Expressive\Config\Provider;

class PhpFileProvider extends FileProvider
{
    use ArrayUtilTrait;

    protected function getConfigFromFile(array $config, string $file) : array
    {
        return self::merge($config, include  $file);
    }
}