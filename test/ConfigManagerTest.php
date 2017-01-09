<?php

namespace Zend\Expressive\Config\Test;

use Zend\Expressive\Config\ConfigManager;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;


class ConfigManagerTest extends \PHPUnit_Framework_TestCase
{
    /** @var ConfigManager */
    private $sut;

    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('root'));
        $this->sut = new ConfigManager(vfsStream::url('root'));
    }

    public function testConfigManager()
    {
        $this->assertInstanceOf(ConfigManager::class, $this->sut);
    }

    public function testConfigManager_ShouldReturnEmptyConfig()
    {
        $this->assertEmpty($this->sut->getConfig());
    }

    public function testConfigManager_ShouldReturnConfigArray()
    {
        $expectedConfig = [
            'parameters' => [
                'db_user' => 'root'
            ]
        ];

        $fileProviderMock = $this->getMockBuilder(FileProviderInterface::class)
            ->setMethods(['getConfig'])
            ->getMock();

        $fileProviderMock
            ->method('getConfig')
            ->willReturn($expectedConfig);

        $this->sut->registerProviders([$fileProviderMock]);

        $config = $this->sut->getConfig();

        $this->assertEquals($config, $expectedConfig);
    }

    public function testConfigManager_ShouldNotSaveConfig()
    {
        $expectedConfig = [
            'config_cache_enabled' => false,
            'parameters' => [
                'db_user' => 'root'
            ]
        ];

        $fileProviderMock = $this->getMockBuilder(FileProviderInterface::class)
            ->setMethods(['getConfig'])
            ->getMock();

        $fileProviderMock
            ->method('getConfig')
            ->willReturn($expectedConfig);

        $this->sut->registerProviders([$fileProviderMock]);
        $this->sut->setCacheFile('/app_config.php');

        $this->sut->getConfig();

        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('app_config.php'));
    }
}