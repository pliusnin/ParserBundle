<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 10:27
 */

namespace ParserBundle\Parser\Scenario;

use ParserBundle\Exception\SubjectsMethodNotImplementedException;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GetText
 * @package ParserBundle\Parser\Scenario
 */
class GetText extends AbstractScenario
{
    /**
     * @param Crawler $crawler
     * @param mixed $subject
     * @return array|mixed
     */
    public function execute(Crawler $crawler, $subject)
    {
        try {
            $data = $crawler->filter($this->selector)->text();
        } catch (\InvalidArgumentException $e) {
            return $subject;
        }

        return $this->setData($subject, $data);
    }
}
