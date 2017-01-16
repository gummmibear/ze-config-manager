<?php

namespace Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zend\Expressive\Config\ConfigFileProviderFactory;
use Zend\Expressive\Config\ConfigFileProviderManager;
use Zend\Expressive\Config\Provider\FileProvider;
use Zend\Expressive\Config\Provider\FileProviderInterface;
use PHPUnit_Framework_MockObject_MockObject as Mock;

class ConfigFileProviderManagerTest extends TestCase
{
    /** @var  FileProvider | Mock */
    private $fileProviderFactoryMock;

    /** @var  ConfigFileProviderManager */
    private $sut;

    public function setUp()
    {
        $this->fileProviderFactoryMock = $this->createMock(ConfigFileProviderFactory::class);
        $this->sut = new ConfigFileProviderManager($this->fileProviderFactoryMock);
    }

    public function testCreateDefaultProvider_ShouldCreateProviders()
    {
        $this->fileProviderFactoryMock
            ->method('getProvider')
            ->withConsecutive(
                [$this->equalTo('php'), $this->equalTo('{{,*.}global,{,*.}local}.php')],
                [$this->equalTo('yml'), $this->equalTo('{*,{{,*.}global,{,*.}local}}.yml')]
            );

        $defaultProviders = $this->sut->createDefaultProviders();

        $this->assertNotEmpty($defaultProviders);
        foreach($defaultProviders as $provider) {
            $this->assertInstanceOf(FileProviderInterface::class, $provider);
        }
    }
}