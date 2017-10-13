<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 17:29
 */

namespace ParserBundle\Tests\Parser;

use ParserBundle\Exception\ParserNotDefinedException;
use ParserBundle\Model\ParserInterface;
use ParserBundle\Parser\ParserLoader;
use ParserBundle\Tests\Model\ParserTest;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ParserLoaderTest
 * @package ParserBundle\Tests\Parser
 */
class ParserLoaderTest extends \PHPUnit_Framework_TestCase
{
    private function initParserLoader($container = null)
    {
        return new ParserLoader($this->getParserList(), $container ?: $this->getContainer());
    }

    public function testLoad()
    {
        $loader = $this->initParserLoader();
        $this->assertInstanceOf(ParserInterface::class, $loader->load('test'));
        $this->expectException(ParserNotDefinedException::class);
        $loader->load('test1');
        $this->expectException(ParserNotDefinedException::class);
        $loader->load('test2');
    }

    public function testLoadService()
    {
        $container = $this->getContainer();
        $container->expects($this->once())->method('has')->with('unknown_parser_service')->willReturn(true);
        $container->expects($this->once())->method('get')->with('unknown_parser_service')->willReturn(
            $this->createMock(ParserInterface::class)
        );
        $loader = $this->initParserLoader($container);
        $this->assertInstanceOf(ParserInterface::class, $loader->load('test2'));
    }

    private function getContainer()
    {
        return $this->createMock(ContainerInterface::class);
    }

    private function getParserList()
    {
        return array(
            'test' => ParserTest::class,
            'test2' => 'unknown_parser_service'
        );
    }
}
