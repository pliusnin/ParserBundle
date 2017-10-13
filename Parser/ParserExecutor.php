<?php
/**
 * Author: Dmitry
 * Date: 16.11.15
 * Time: 11:48
 */

namespace ParserBundle\Parser;

use ParserBundle\Exception\ParserException;
use ParserBundle\Model\ParserInterface;
use ParserBundle\Storage\StorageInterface;

class ParserExecutor
{
    /**
     * @var \ParserBundle\Storage\StorageInterface
     */
    private $storage;

    /**
     * @var ScenarioBuilder
     */
    private $scenarioBuilder;

    /**
     * @var ScenarioHandler
     */
    private $scenarioHandler;

    /**
     * @var Requester
     */
    private $requester;

    /**
     * @param StorageInterface $storage
     * @param ScenarioBuilder $scenarioBuilder
     * @param ScenarioHandler $scenarioHandler
     * @param Requester $requester
     */
    public function __construct(
        StorageInterface $storage,
        ScenarioBuilder $scenarioBuilder,
        ScenarioHandler $scenarioHandler,
        Requester $requester
    ) {
        $this->storage = $storage;
        $this->scenarioBuilder = $scenarioBuilder;
        $this->scenarioHandler = $scenarioHandler;
        $this->requester = $requester;
    }

    /**
     * @param ParserInterface $parser
     * @return bool|null
     * @throws ParserException
     */
    public function run(ParserInterface $parser)
    {
        $parser->buildScenario($this->scenarioBuilder);
        $subject = $parser->createSubjectInstance();
        $crawler = $this->requester->getHtml($parser->getTargetUrl());
        $scenario = $this->scenarioBuilder->getScenario();
        $subjectResult = $this->scenarioHandler->handle($scenario, $crawler, $subject);

        if (empty($subjectResult)) {
            throw new ParserException('Scenario is empty.');
        }

        $subjectResult = $parser->preSave($subjectResult);

        if (is_null($subjectResult)) {
            return null;
        }

        if (is_array($subjectResult)) {
            foreach ($subjectResult as $subjectObject) {
                $this->storage->save($subjectObject);
            }
        } else {
            $this->storage->save($subjectResult);
        }

        return true;
    }
}
