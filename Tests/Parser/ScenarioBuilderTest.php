<?php
/**
 * Author: Dmitry
 * Date: 01.04.16
 * Time: 16:51
 */

namespace ParserBundle\Tests\Parser;

use ParserBundle\Parser\Requester;
use ParserBundle\Parser\ScenarioBuilder;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ScenarioBuilderTest
 * @package ParserBundle\Tests\Parser
 */
class ScenarioBuilderTest extends \PHPUnit_Framework_TestCase
{
    public function testExecuteScenario()
    {
        $subject = array();
        $scenarioBuilder = $this->getScenarioBuilder();
        $result = $scenarioBuilder->executeScenario('http://localhost', $subject);

        $this->assertEquals(2, count($result));
    }

    private function getScenarioBuilder()
    {
        $crawler = new Crawler('<body><ul><li><h1 class="header1">Test 1</h1></li><li><h1 class="header2">Test 2</h1></li></ul></body>');
        $requester = $this->createMock(Requester::class);
        $requester->expects($this->once())->method('getHtml')->will($this->returnValue($crawler));

        $scenarioBuilder = new ScenarioBuilder($requester);
        $scenarioBuilder
            ->iterate('li')
                ->getHtml('h1', 'field1')
                ->getText('h1', 'field2')
                ->getTextAttr('h1', 'class', 'field3')
            ->endIterate()
        ;

        return $scenarioBuilder;
    }
}
