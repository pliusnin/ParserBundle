<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 10:27
 */

namespace ParserBundle\Parser\Scenario;

use Symfony\Component\DomCrawler\Crawler;

/**
 * Class GetTextAttr
 * @package ParserBundle\Parser\Scenario
 */
class GetTextAttr extends GetText
{
    /**
     * @var string
     */
    private $attrName;

    /**
     * @param string $selector
     * @param callable|null|string $attrName
     * @param $mappedTarget
     */
    public function __construct($selector, $attrName, $mappedTarget)
    {
        parent::__construct($selector, $mappedTarget);

        $this->attrName = $attrName;
    }

    /**
     * @param Crawler $crawler
     * @param mixed $subject
     * @return array|mixed
     */
    public function execute(Crawler $crawler, $subject)
    {
        try {
            $data = $crawler->filter($this->selector)->attr($this->attrName);
        } catch (\InvalidArgumentException $e) {
            return $subject;
        }

        return $this->setData($subject, $data);
    }
}
