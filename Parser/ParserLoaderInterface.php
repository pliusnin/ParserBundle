<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 16:59
 */

namespace ParserBundle\Parser;

use ParserBundle\Model\ParserInterface;

/**
 * Interface ParserLoaderInterface
 * @package ParserBundle\Parser
 */
interface ParserLoaderInterface
{
    /**
     * @param string $name
     * @return ParserInterface
     */
    public function load($name);
}