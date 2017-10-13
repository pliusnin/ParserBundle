<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 15:58
 */

namespace ParserBundle\Storage;

/**
 * Interface StorageInterface
 * @package ParserBundle\Storage
 */
interface StorageInterface
{
    /**
     * @param mixed $object
     */
    public function save($object);
}
