<?php
/**
 * Author: Dmitry
 * Date: 17.11.15
 * Time: 23:20
 */

namespace ParserBundle\Parser;

use ParserBundle\Exception\ParserScenarioException;
use ParserBundle\Parser\Scenario;

/**
 * Class ScenarioBuilder
 * @package ParserBundle\Parser
 */
class ScenarioBuilder
{
    /**
     * @var Scenario\ScenarioInterface[]
     */
    private $scenario;

    /**
     * @var Requester
     */
    private $requester;

    /**
     * @param Requester $requester
     */
    public function __construct(Requester $requester)
    {
        $this->scenario = array();
        $this->requester = $requester;
    }

    /**
     * Get text from element by given selector and set to target field.
     * Or you can use callback function to handle data with subject.
     *
     * @param string $selector
     * @param string|callable $target String field name or callable function with parameters $subject and $data
     * @return $this
     */
    public function getText($selector, $target)
    {
        $this->addScene(new Scenario\GetText($selector, $target));

        return $this;
    }

    /**
     * Get attribute value from element by given selector and set to target field.
     * Or you can use callback function to handle data with subject.
     *
     * @param string $selector
     * @param string $attr
     * @param string|callable $target String field name or callable function with parameters $subject and $data
     * @return $this
     */
    public function getTextAttr($selector, $attr, $target)
    {
        $this->addScene(new Scenario\GetTextAttr($selector, $attr, $target));

        return $this;
    }

    /**
     * Get html from element by given selector and set to target field.
     * Or you can use callback function to handle data with subject.
     *
     * @param string $selector
     * @param string|callable $target String field name or callable function with parameters $subject and $data
     * @return $this
     */
    public function getHtml($selector, $target)
    {
        $this->addScene(new Scenario\GetHtml($selector, $target));

        return $this;
    }

    /**
     * Iterate over elements by given selector
     *
     * @param string $selector
     * @param null|integer $numberOfItems
     * @return $this
     */
    public function iterate($selector, $numberOfItems = null)
    {
        $this->addScene(new Scenario\Iterate($selector, null, $numberOfItems));

        return $this;
    }

    /**
     * Finish the Iterate method
     *
     * @throws \ParserBundle\Exception\ParserScenarioException
     * @return bool
     */
    public function endIterate()
    {
        $iterateScenarios = array();
        
        while (!($previousScenario = array_pop($this->scenario)) instanceof Scenario\Iterate) {
            $iterateScenarios[] = $previousScenario;

            if (empty($this->scenario)) {
                throw new ParserScenarioException('"endIterate" should be used with "iterate" scene.');
            }
        }

        while ($scene = array_pop($iterateScenarios)) {
            $previousScenario->addChild($scene);
        }

        $this->scenario[] = $previousScenario;

        return true;
    }

    /**
     * Get the Href attr from element by given selector and update crawler object
     *
     * @param string $selector
     * @param string|null $domain If URLs without domain are used
     * @return $this
     */
    public function gotoLink($selector, $domain = null)
    {
        $this->addScene(new Scenario\GoToLink($selector, $domain, $this->requester));

        return $this;
    }

    /**
     * @return Scenario\ScenarioInterface[]
     */
    public function getScenario()
    {
        return $this->scenario;
    }

    /**
     * @param Scenario\ScenarioInterface $scene
     */
    private function addScene(Scenario\ScenarioInterface $scene)
    {
        $this->scenario[] = $scene;
    }
}
