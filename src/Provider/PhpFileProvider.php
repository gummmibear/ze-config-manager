<?php

namespace Zend\Expressive\Config\Provider;

use SplFileInfo;

class PhpFileProvider extends FileProvider
{
    use ArrayUtilTrait;
    /**
     * {@inheritdoc}
     */
    protected function getConfigFromFile(array $config, SplFileInfo $file) : array
    {
        return self::merge($config, include  $file->getRealPath());
    }
}