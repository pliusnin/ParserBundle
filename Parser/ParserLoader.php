<?php
/**
 * Author: Dmitry
 * Date: 31.03.16
 * Time: 16:59
 */

namespace ParserBundle\Parser;

use ParserBundle\Exception\ParserNotDefinedException;
use ParserBundle\Model\ParserInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;

/**
 * Class ParserLoader
 * @package ParserBundle\Parser
 */
class ParserLoader implements ParserLoaderInterface
{
    /**
     * @var array
     */
    private $parsers;

    /**
     * @var ContainerInterface
     */
    private $container;

    public function __construct($parserList, ContainerInterface $container)
    {
        $this->parsers = $parserList;
        $this->container = $container;
    }

    /**
     * @param string $name
     * @throws \ParserBundle\Exception\ParserNotDefinedException
     * @return ParserInterface
     */
    public function load($name)
    {
        if (isset($this->parsers[$name])) {
            if ($this->container->has($this->parsers[$name])) {
                return $this->container->get($this->parsers[$name]);
            } elseif ($parser = $this->loadFromClass($this->parsers[$name])) {
                return $parser;
            }
        }

        throw new ParserNotDefinedException(
            sprintf(
                'Parser with name %s is not defined. Defined parsers are: %s',
                $name,
                implode(', ', array_keys($this->parsers))
            )
        );
    }

    /**
     * @param $className
     * @return null
     */
    private function loadFromClass($className)
    {
        if (!class_exists($className)) {
            return null;
        }

        return new $className;
    }
}
