<?php
namespace Zend\Expressive\Config\Test;

use PHPUnit\Framework\TestCase;
use Zend\Expressive\Config\ConfigFileProviderFactory;
use Zend\Expressive\Config\Provider\PhpFileProvider;
use Zend\Expressive\Config\Provider\YamlFileProvider;

class ConfigFileProviderFactoryTest extends TestCase
{
    /** @var ConfigFileProviderFactory */
    private $sut;

    public function setUp()
    {
        $this->sut = new ConfigFileProviderFactory(__DIR__);
    }

    /**
     * @dataProvider dpProvider
     */
    public function testGetProvider_ShouldReturnFileProvider($providerName, $expectedProvider)
    {
        $this->assertInstanceOf($expectedProvider, $this->sut->getProvider($providerName, 'pattern'));
    }

    public function testGetProvider_ShouldThrowException_IfProviderNotFound()
    {
        $providerName = 'xml';
        $this->expectException(\RuntimeException::class);
        $this->expectExceptionMessage(sprintf('Provider for %s not found', $providerName));

        $this->sut->getProvider($providerName, 'pattern');
    }

    public function dpProvider()
    {
        return [
            [ConfigFileProviderFactory::PHP_PROVIDER, PhpFileProvider::class],
            [ConfigFileProviderFactory::YML_PROVIDER, YamlFileProvider::class]
        ];
    }
}