<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 16:40
 */

namespace ParserBundle\Event;

use ParserBundle\Model\ParserInterface;
use Symfony\Component\EventDispatcher\Event;

/**
 * Class ParserEvent
 * @package ParserBundle\Event
 */
class ParserEvent extends Event
{
    /**
     * @var ParserInterface
     */
    private $parser;

    public function __construct(ParserInterface $parser)
    {
        $this->parser = $parser;
    }

    /**
     * @return ParserInterface
     */
    public function getParser()
    {
        return $this->parser;
    }
}
