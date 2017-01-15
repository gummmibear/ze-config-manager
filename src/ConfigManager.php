<?php

namespace Zend\Expressive\Config;

use Zend\Expressive\Config\Provider\FileProviderInterface;
use Zend\Stdlib\ArrayUtils;

class ConfigManager
{
    const DEFAULT_CACHE_FILE = '/../data/cache/app_config.php';

    /** @var FileProviderInterface[] */
    private $providers = [];

    /** @var string */
    private $rootDir;

    /** @var string */
    private $cacheFile = self::DEFAULT_CACHE_FILE;

    public function __construct($rootDir)
    {
        $this->rootDir = $rootDir;
    }

    public function setCacheFile($cacheFile)
    {
        $this->cacheFile = $cacheFile;
    }

    public function registerProviders(array $providers)
    {
        $this->providers = array_merge($this->providers, $providers);
    }

    public function getConfig() : array
    {
        if (!empty($cachedConfig = $this->getCachedConfig())) {
            return $cachedConfig;
        }

        $config = [];

        foreach($this->providers as $fileProvider) {
            $config = ArrayUtils::merge($config, $fileProvider->getConfig());
        }

        $config = $this->resolveVariables($config);

        $this->cacheConfig($config);

        return $config;
    }

    private function cacheConfig(array $config)
    {
        // Cache config if enabled
        if (isset($config['config_cache_enabled']) && $config['config_cache_enabled'] === true) {
            $cachedConfigFile = $this->getCachedFilePath();
            file_put_contents($cachedConfigFile, '<?php return ' . var_export($config, true) . ';');
        }
    }

    private function getCachedConfig() : array
    {
        if (is_file($cachedConfigFile = $this->getCachedFilePath())) {
            return include $cachedConfigFile;
        }

        return [];
    }

    private function resolveVariables(array $config): array
    {
        $parameters = [];
        if (isset($config['parameters'])) {
            $parameters = $config['parameters'];
        }

        array_walk_recursive(
            $config,
            function(&$val, $key) use($parameters){
                $matches = [];
                preg_match_all('/\%(.*?)\%/', $val, $matches);

                $matches = isset($matches[1]) ? $matches[1] : [];
                if (count($matches)) {
                    foreach($matches as $param) {
                        if (isset($parameters[$param])) {
                            $val = str_replace("%$param%", $parameters[$param], $val);
                        }
                    }
                }
            }
        );

        return $config;
    }

    private function getCachedFilePath() : string
    {
        return $this->rootDir . $this->getCachedFile();
    }

    private function getCachedFile() : string
    {
        return $this->cacheFile;
    }
}