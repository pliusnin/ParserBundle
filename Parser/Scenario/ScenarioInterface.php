<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 10:24
 */

namespace ParserBundle\Parser\Scenario;

use Symfony\Component\DomCrawler\Crawler;

interface ScenarioInterface
{
    /**
     * @param Crawler $crawler
     * @param mixed $subject
     * @return mixed
     */
    public function execute(Crawler $crawler, $subject);
}