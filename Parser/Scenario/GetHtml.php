<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 10:27
 */

namespace ParserBundle\Parser\Scenario;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GetHtml
 * @package ParserBundle\Parser\Scenario
 */
class GetHtml extends GetText
{
    /**
     * @param Crawler $crawler
     * @param mixed $subject
     * @return array|mixed
     */
    public function execute(Crawler $crawler, $subject)
    {
        try {
            $data = $crawler->filter($this->selector)->html();
        } catch (\InvalidArgumentException $e) {
            return $subject;
        }

        return $this->setData($subject, $data);
    }
}
