<?php
/**
 * Author: Dmitry
 * Date: 06.04.16
 * Time: 16:44
 */

namespace ParserBundle\Model;

/**
 * Class AbstractParser
 * @package ParserBundle\Model
 */
abstract class AbstractParser implements ParserInterface
{
    /**
     * @param mixed $subject
     * @return mixed
     */
    public function preSave($subject)
    {
        return $subject;
    }
}
