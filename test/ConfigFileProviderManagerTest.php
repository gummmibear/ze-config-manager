<?php

namespace Zend\Expressive\Config\Test;


use PHPUnit\Framework\TestCase;
use Zend\Expressive\Config\ConfigFileProviderFactory;
use Zend\Expressive\Config\ConfigFileProviderManager;
use Zend\Expressive\Config\Provider\FileProviderInterface;

class ConfigFileProviderManagerTest extends TestCase
{
    /** @var  ConfigFileProviderManager */
    private $sut;

    public function setUp()
    {
        $fileProviderFactoryMock = $this->createMock(ConfigFileProviderFactory::class);
        $this->sut = new ConfigFileProviderManager($fileProviderFactoryMock);
    }

    public function testCreateDefaultProvider_ShouldCreateProviders()
    {
        $defaultProviders = $this->sut->createDefaultProviders();

        $this->assertNotEmpty($defaultProviders);
        foreach($defaultProviders as $provider) {
            $this->assertInstanceOf(FileProviderInterface::class, $provider);
        }
    }
}