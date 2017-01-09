<?php

namespace Zend\Expressive\Config\Provider;

use GlobIterator;
use FilesystemIterator;

abstract class FileProvider implements FileProviderInterface
{
    private $pattern;

    /**
     * Provider constructor.
     * @param $pattern
     */
    public function __construct($pattern)
    {
        $this->pattern = $pattern;
    }

    /**
     * @inheritdoc
     */
    public function getConfig() : array
    {
        $config = [];
        foreach ($this->iterate($this->pattern) as $file) {
            $config = $this->getConfigFromFile($config, $file);
        }

        return $config;
    }


    /**
     * @param $pattern
     *
     * @return GlobIterator
     */
    private function iterate($pattern) : GlobIterator
    {
        return new GlobIterator($pattern, FilesystemIterator::SKIP_DOTS);
    }
}