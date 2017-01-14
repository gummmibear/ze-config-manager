<?php

namespace Zend\Expressive\Config\Provider;

use Zend\Stdlib\Glob;

abstract class FileProvider implements FileProviderInterface
{
    private $pattern;

    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    public function getConfig() : array
    {
        $config = [];
        foreach ($this->iterate($this->pattern) as $file) {
            $config = $this->getConfigFromFile($config, $file);
        }

        return $config;
    }

    abstract protected function getConfigFromFile(array $config, string $file) : array;

    private function iterate($pattern):array
    {
        return Glob::glob($pattern, Glob::GLOB_BRACE);
    }
}