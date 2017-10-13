<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 10:27
 */

namespace ParserBundle\Parser\Scenario;

use ParserBundle\Exception\SubjectsMethodNotImplementedException;
use ParserBundle\Parser\Requester;
use ParserBundle\Parser\Transport;
use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GetText
 * @package ParserBundle\Parser\Scenario
 */
class GoToLink extends AbstractScenario
{
    /**
     * @var \ParserBundle\Parser\Requester
     */
    private $requester;

    /**
     * @param string $selector
     * @param null|string $mappedTarget
     * @param Requester $requester
     */
    public function __construct($selector, $mappedTarget = null, Requester $requester)
    {
        $this->requester = $requester;

        parent::__construct($selector, $mappedTarget);
    }

    /**
     * @param Crawler $crawler
     * @param mixed $subject
     * @return mixed
     */
    public function execute(Crawler $crawler, $subject)
    {
        try {
            $link = $crawler->filter($this->selector)->attr('href');
            $crawler->clear();
            $crawler->addHtmlContent($this->requester->getHtml($this->mappedTarget.$link)->html());
        } catch (\InvalidArgumentException $e) {
            // TODO: need invalidate crawler object to prevent parsing incorrect data
        }

        return $subject;
    }
}
