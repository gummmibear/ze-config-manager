<?php
namespace Zend\Expressive\Config;

use Zend\Expressive\Config\Provider\FileProviderInterface;

class ConfigFileProviderManager
{
    /** @var [] */
    private $autoloadFilePattern = [
        'php' => '{{,*.}global,{,*.}local}.php',
        'yml' => '{*,{{,*.}global,{,*.}local}}.yml'
    ];

    public function __construct(ConfigFileProviderFactory $fileProviderFactory)
    {
        $this->fileProviderFactory = $fileProviderFactory;
    }

    /**
     * @return FileProviderInterface[]
     */
    public function createDefaultProviders()
    {
        $providers = [];
        foreach($this->autoloadFilePattern as $providerKey => $pattern) {
            $providers[] = $this->fileProviderFactory->getProvider($providerKey, $pattern);
        }

        return $providers;
    }
}