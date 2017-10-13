<?php
/**
 * Author: Dmitry
 * Date: 18.11.15
 * Time: 11:45
 */

namespace ParserBundle\Parser\Scenario;

use ParserBundle\Exception\ParserScenarioException;
use ParserBundle\Exception\SubjectsMethodNotImplementedException;

abstract class AbstractScenario implements ScenarioInterface
{
    /**
     * @var string
     */
    protected $selector;

    /**
     * @var string|callable
     */
    protected $mappedTarget;

    /**
     * @param string $selector
     * @param string|callable|null $mappedTarget
     */
    public function __construct($selector, $mappedTarget = null)
    {
        $this->selector = $selector;
        $this->mappedTarget = $mappedTarget;
    }

    /**
     * @param $subject
     * @param $data
     * @return array
     * @throws \ParserBundle\Exception\ParserScenarioException
     */
    protected function setData($subject, $data)
    {
        if (is_callable($this->mappedTarget)) {
            call_user_func($this->mappedTarget, $subject, $data);

            return $subject;
        }

        if (is_string($this->mappedTarget)) {
            if (is_array($subject)) {
                $subject[$this->mappedTarget] = $data;
            } else {
                $this->setProperty($subject, $data);
            }

            return $subject;
        }

        if (is_null($this->mappedTarget) && is_array($subject)) {
            $subject[] = $data;

            return $subject;
        }

        throw new ParserScenarioException(
            'MappedTarget property should be defined if type of Object for subject is used.'
        );
    }

    /**
     * @param mixed $subject
     * @param mixed $data
     * @throws SubjectsMethodNotImplementedException
     */
    private function setProperty($subject, $data)
    {
        $setter = 'set'.ucfirst($this->mappedTarget);

        if (!method_exists($subject, $setter)) {
            throw new SubjectsMethodNotImplementedException(
                'You must implement "'.$setter.'" for the class '.get_class($subject)
            );
        }

        $subject->{$setter}($data);
    }
}
