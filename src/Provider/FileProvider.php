<?php

namespace Zend\Expressive\Config\Provider;

use GlobIterator;
use FilesystemIterator;

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

    abstract protected function getConfigFromFile(array $config, \SplFileInfo $file) : array;

    private function iterate($pattern) : GlobIterator
    {
        return new GlobIterator($pattern, FilesystemIterator::SKIP_DOTS);
    }
}