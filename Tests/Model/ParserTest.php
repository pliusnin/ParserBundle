<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 20:24
 */

namespace ParserBundle\Tests\Model;

use ParserBundle\Model\AbstractParser;
use ParserBundle\Parser\ScenarioBuilder;

class ParserTest extends AbstractParser
{

    /**
     * URL which is start page of parsing
     *
     * @return string
     */
    public function getTargetUrl()
    {
        return 'http://localhost';
    }

    /**
     * @param ScenarioBuilder $scenarioBuilder
     */
    public function buildScenario(ScenarioBuilder $scenarioBuilder)
    {
    }

    /**
     * @return mixed
     */
    public function createSubjectInstance()
    {
    }
}
