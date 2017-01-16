<?php

namespace Zend\Expressive\Config\Test;

use Zend\Expressive\Config\ConfigManager;
use Zend\Expressive\Config\Provider\FileProviderInterface;
use org\bovigo\vfs\vfsStreamWrapper;
use org\bovigo\vfs\vfsStreamDirectory;
use org\bovigo\vfs\vfsStream;
use PHPUnit\Framework\TestCase;

class ConfigManagerTest extends TestCase
{
    /** @var ConfigManager */
    private $sut;

    public function setUp()
    {
        vfsStreamWrapper::register();
        vfsStreamWrapper::setRoot(new vfsStreamDirectory('root'));
        $this->sut = new ConfigManager(vfsStream::url('root'));
    }

    public function testConfigManagerInstance()
    {
        $this->assertInstanceOf(ConfigManager::class, $this->sut);
    }

    public function testConfigManager_ShouldReturnEmptyConfig()
    {
        $this->assertEmpty($this->sut->getConfig());
    }

    public function testConfigManager_ShouldReturnConfigArrayAndResolveVariables()
    {
        $expectedConfig = [
            'parameters' => [
                'db_user' => 'root',
                'db_host' => 'localhost'
            ],
            'mysql' => [
                'link' => 'mysql://root@localhost'
            ]
        ];

        $fileProviderMock = $this->createMock(FileProviderInterface::class);

        $fileProviderMock
            ->method('getConfig')
            ->willReturn([
                    'parameters' => [
                        'db_user' => 'root',
                        'db_host' => 'localhost'
                    ],
                    'mysql' => [
                        'link' => 'mysql://%db_user%@%db_host%'
                    ]
                ]
            );

        $this->sut->registerProviders([$fileProviderMock]);

        $config = $this->sut->getConfig();

        $this->assertEquals($config, $expectedConfig);
    }

    public function testConfigManager_ShouldSaveConfig()
    {
        $expectedConfig = [
            'config_cache_enabled' => true,
            'parameters' => [
                'db_user' => 'root'
            ]
        ];

        $fileProviderMock = $this->createMock(FileProviderInterface::class);

        $fileProviderMock
            ->method('getConfig')
            ->willReturn($expectedConfig);

        $this->sut->registerProviders([$fileProviderMock]);
        $this->sut->setCacheFile('/app_config.php');

        $this->sut->getConfig();

        $this->assertTrue(vfsStreamWrapper::getRoot()->hasChild('app_config.php'));
    }

    public function testConfigManager_ShouldNotSaveConfig()
    {
        $expectedConfig = [
            'config_cache_enabled' => false,
            'parameters' => [
                'db_user' => 'root'
            ]
        ];

        $fileProviderMock = $this->createMock(FileProviderInterface::class);

        $fileProviderMock
            ->method('getConfig')
            ->willReturn($expectedConfig);

        $this->sut->registerProviders([$fileProviderMock]);
        $this->sut->setCacheFile('/app_config.php');

        $this->sut->getConfig();

        $this->assertFalse(vfsStreamWrapper::getRoot()->hasChild('app_config.php'));
    }
}