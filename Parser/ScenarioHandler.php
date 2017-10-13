<?php
/**
 * Author: Dmitry Pliusnin
 * Date: 12.10.17
 * Time: 1:18
 */

namespace ParserBundle\Parser;

use ParserBundle\Parser\Scenario\ScenarioInterface;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class ScenarioHandler
 * @package ParserBundle\Parser
 */
class ScenarioHandler
{
    /**
     * @param ScenarioInterface[] $scenario
     * @param Crawler|string $source Crawler object or HTML string
     * @param mixed $subject Target source
     * @return array|null|object
     */
    public function handle($scenario, $source, $subject)
    {
        if (!$source instanceof Crawler) {
            $source = new Crawler($source);
        }

        $subjectResult = null;

        foreach ($scenario as $scene) {
            $subjectResult = $scene->execute($source, $subject);
        }

        return $subjectResult;
    }
}
