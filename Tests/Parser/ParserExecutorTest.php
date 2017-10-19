<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 20:35
 */

namespace ParserBundle\Tests\Parser;

use ParserBundle\Exception\ParserException;
use ParserBundle\Model\AbstractParser;
use ParserBundle\Parser\ParserExecutor;
use ParserBundle\Parser\Requester;
use ParserBundle\Parser\ScenarioBuilder;
use ParserBundle\Parser\ScenarioHandler;
use ParserBundle\Storage\StorageInterface;

/**
 * Class ParserExecutorTest
 * @package ParserBundle\Tests\Parser
 */
class ParserExecutorTest extends \PHPUnit_Framework_TestCase
{
    private function getParser()
    {
        return $this->createMock(AbstractParser::class);
    }

    private function getStorage()
    {
        return $this->createMock(StorageInterface::class);
    }

    private function getScenarioBuilder()
    {
        return $this->createMock(ScenarioBuilder::class);
    }

    private function getScenarioHandler()
    {
        return $this->createMock(ScenarioHandler::class);
    }

    private function getRequester()
    {
        return $this->createMock(Requester::class);
    }

    /**
     * @param null $storage
     * @param null $scenarioBuilder
     * @param null $scenarioHandler
     * @param null $requester
     * @return ParserExecutor
     */
    private function getParserExecutor(
        $storage = null,
        $scenarioBuilder = null,
        $scenarioHandler = null,
        $requester = null
    ) {
        $parserHandler = new ParserExecutor(
            $storage ?: $this->getStorage(),
            $scenarioBuilder ?: $this->getScenarioBuilder(),
            $scenarioHandler ?: $this->getScenarioHandler(),
            $requester ?: $this->getRequester()
        );

        return $parserHandler;
    }

    public function testRunEmptyScenario()
    {
        $parserHandler = $this->getParserExecutor();
        $this->expectException(ParserException::class);
        $parserHandler->run($this->getParser());
    }

    public function testRunSave()
    {
        $scenario = [];
        $scenarioBuilder = $this->getScenarioBuilder();
        $scenarioBuilder
            ->expects($this->once())
            ->method('getScenario')
            ->willReturn($scenario)
        ;

        $scenarioHandler = $this->getScenarioHandler();
        $scenarioHandler
            ->expects($this->once())
            ->method('handle')
            ->willReturn(1)
        ;

        $storage = $this->getStorage();
        $storage->expects($this->once())->method('save');

        $parser = $this->getParser();
        $parser->expects($this->once())->method('preSave')->willReturn(1);

        $parserExecutor = $this->getParserExecutor($storage, $scenarioBuilder, $scenarioHandler);

        $result = $parserExecutor->run($parser);
        $this->assertTrue($result);
    }

    public function testRunSaveArray()
    {
        $data = [1, 2];
        $scenarioBuilder = $this->getScenarioBuilder();
        $scenarioBuilder
            ->expects($this->once())
            ->method('getScenario')
        ;

        $scenarioHandler = $this->getScenarioHandler();
        $scenarioHandler
            ->expects($this->once())
            ->method('handle')
            ->willReturn($data)
        ;

        $storage = $this->getStorage();
        $storage->expects($this->atLeast(2))->method('save');
        $parserExecutor = $this->getParserExecutor($storage, $scenarioBuilder, $scenarioHandler);

        $parser = $this->getParser();
        $parser->expects($this->once())->method('preSave')->willReturn($data);

        $result = $parserExecutor->run($parser);
        $this->assertTrue($result);
    }

    public function testRunSaveNullResult()
    {
        $scenarioBuilder = $this->getScenarioBuilder();
        $scenarioBuilder
            ->expects($this->once())
            ->method('getScenario')
            ->willReturn(1)
        ;

        $scenarioHandler = $this->getScenarioHandler();
        $scenarioHandler
            ->expects($this->once())
            ->method('handle')
            ->willReturn(1)
        ;

        $parserHandler = $this->getParserExecutor(null, $scenarioBuilder, $scenarioHandler);
        $parser = $this->getParser();
        $result = $parserHandler->run($parser);
        $this->assertNull($result);
    }
}
