<?php
/**
 * Author: Dmitry
 * Date: 16.11.15
 * Time: 12:24
 */

namespace ParserBundle\Model;

use ParserBundle\Parser\ScenarioBuilder;

/**
 * Interface ParserMappingInterface
 * @package ParserBundle\Parser\Mapping
 */
interface ParserInterface
{
    /**
     * URL which is start page of parsing
     *
     * @return string
     */
    public function getTargetUrl();

    /**
     * @param ScenarioBuilder $scenarioBuilder
     */
    public function buildScenario(ScenarioBuilder $scenarioBuilder);

    /**
     * @return mixed
     */
    public function createSubjectInstance();

    /**
     * @param mixed $subject
     * @return mixed
     */
    public function preSave($subject);
}
