<?php
namespace Zend\Expressive\Config\Test\Provider;


use PHPUnit\Framework\TestCase;
use Zend\Expressive\Config\Provider\PhpFileProvider;

class PhpFileProviderTest extends TestCase
{
    /** @var  PhpFileProvider */
    private $sut;

    public function setUp()
    {
        $this->sut = new PhpFileProvider(__DIR__ . '/Resources/{{,*.}global,{,*.}local}.php');
    }

    public function testGetConfig()
    {
        $expectedConfig = [
            'debug' => true,
            'config_cache_enabled' => false,
        ];

        $this->assertEquals($expectedConfig, $this->sut->getConfig());
    }
}