<?php

namespace Zend\Expressive\Config\Provider;

interface FileProviderInterface
{
    public function getConfig() : array;
}