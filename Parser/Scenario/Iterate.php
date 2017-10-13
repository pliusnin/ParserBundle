<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 14:14
 */

namespace ParserBundle\Parser\Scenario;

use ParserBundle\Exception\ParserScenarioException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class Iterate
 * @package ParserBundle\Parser\Scenario
 */
class Iterate extends AbstractScenario
{
    /**
     * @var ScenarioInterface[]
     */
    protected $children;

    /**
     * @var integer|null
     */
    protected $numberOfItems;

    public function __construct($selector, $mappedTarget, $numberOfItems)
    {
        $this->numberOfItems = $numberOfItems;
        parent::__construct($selector, $mappedTarget);
    }

    /**
     * @param Crawler $crawler
     * @param mixed $subject
     * @return array
     */
    public function execute(Crawler $crawler, $subject)
    {
        $resultArray = $crawler->filter($this->selector)->each(function (Crawler $node, $i) use ($subject) {
            if ($this->numberOfItems && $i >= $this->numberOfItems) {
                return null;
            }

            $subjectNew = is_object($subject) ? clone $subject : $subject;

            try {
                foreach ($this->children as $child) {
                    $subjectNew = $child->execute($node, $subjectNew);
                }
            } catch (\InvalidArgumentException $e) {
                throw new ParserScenarioException('Node is incorrect. Dump HTML: '.$node->html(), 500, $e);
            }

            return $subjectNew;
        });

        return array_filter($resultArray);
    }

    /**
     * @param ScenarioInterface $scenario
     */
    public function addChild(ScenarioInterface $scenario)
    {
        $this->children[] = $scenario;
    }
}
