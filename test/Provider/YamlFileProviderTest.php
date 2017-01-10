<?php
namespace Zend\Expressive\Config\Test\Provider;

use PHPUnit\Framework\TestCase;
use Zend\Expressive\Config\Provider\YamlFileProvider;

class YamlFileProviderTest extends TestCase
{
    /** @var  YamlFileProvider */
    private $sut;

    public function setUp()
    {
        $this->sut = new YamlFileProvider(__DIR__ . '/Resources/*.yml');
    }

    public function testGetConfig_ShouldReturnArray()
    {
        $expectedArray = [
            'debug' => true,
            'config_cache_enabled' => false,
            'mysql' => [
                'db_user' => 'root',
                'db_password' => 'root'
            ],
        ];

        $config = $this->sut->getConfig();

        $this->assertEquals($expectedArray, $config);
    }
}