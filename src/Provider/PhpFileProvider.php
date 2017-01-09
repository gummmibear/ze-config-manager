<?php

namespace Zend\Expressive\Config\Provider;

use Zend\Stdlib\ArrayUtils;
use SplFileInfo;

class PhpFileProvider extends FileProvider
{
    /**
     * {@inheritdoc}
     */
    public function getConfigFromFile(array $config, SplFileInfo $file) : array
    {
        return ArrayUtils::merge($config, include  $file->getRealPath());
    }
}