<?php
/**
 * Author: Dmitry
 * Date: 01.04.16
 * Time: 16:51
 */

namespace ParserBundle\Tests\Parser;

use ParserBundle\Parser\Requester;
use ParserBundle\Parser\ScenarioBuilder;
use ParserBundle\Parser\ScenarioHandler;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ScenarioBuilderTest
 * @package ParserBundle\Tests\Parser
 */
class ScenarioHandlerTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteScenario()
    {
        $crawler = new Crawler('<body><ul><li><h1 class="header1">Test 1</h1></li><li><h1 class="header2">Test 2</h1></li></ul></body>');
        $scenarioHandler = new ScenarioHandler();
        $result = $scenarioHandler->handle($this->getScenario(), $crawler, []);

        $this->assertTrue(is_array($result));
        $this->assertCount(2, $result);
        $this->assertArrayHasKey('field1', $result[0]);
        $this->assertArrayHasKey('field2', $result[0]);
        $this->assertArrayHasKey('field3', $result[0]);
    }

    /**
     * @return \ParserBundle\Parser\Scenario\ScenarioInterface[]
     */
    private function getScenario()
    {
        $requester = $this->createMock(Requester::class);

        $scenarioBuilder = new ScenarioBuilder($requester);
        $scenarioBuilder
            ->iterate('li')
            ->getHtml('h1', 'field1')
            ->getText('h1', 'field2')
            ->getTextAttr('h1', 'class', 'field3')
            ->endIterate()
        ;

        return $scenarioBuilder->getScenario();
    }
}
