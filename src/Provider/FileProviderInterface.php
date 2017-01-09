<?php

namespace Zend\Expressive\Config\Provider;

interface FileProviderInterface
{
    public function getConfig() : array;

    public function getConfigFromFile(array $config, \SplFileInfo $file) : array;
}