<?php

namespace Zend\Expressive\Config\Provider;

class PhpFileProvider extends FileProvider
{
    use ArrayUtilTrait;

    protected function getConfigFromFile(array $config, \SplFileInfo $file) : array
    {
        return self::merge($config, include  $file->getRealPath());
    }
}