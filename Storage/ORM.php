<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 15:58
 */

namespace ParserBundle\Storage;

use Doctrine\ORM\EntityManager;

/**
 * Class ORM
 * @package ParserBundle\Storage
 */
class ORM implements StorageInterface
{
    /**
     * @var \Doctrine\ORM\EntityManager
     */
    private $em;

    /**
     * @param EntityManager $entityManager
     */
    public function __construct(EntityManager $entityManager)
    {
        $this->em = $entityManager;
    }

    public function save($object)
    {
        $this->em->persist($object);
        $this->em->flush();
    }
}
