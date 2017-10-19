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
        $scenarioBuilder = $this->getScenarioBuilder();
        $scenario = $scenarioBuilder->getScenario();

        $this->assertTrue(is_array($scenario));
    }

    private function getScenarioBuilder()
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

        return $scenarioBuilder;
    }
}
