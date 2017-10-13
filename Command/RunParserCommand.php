<?php
/**
 * Author: Dmitry
 * Date: 16.11.15
 * Time: 10:50
 */

namespace ParserBundle\Command;

use ParserBundle\Event\ParserEvent;
use ParserBundle\Model\ParserInterface;
use ParserBundle\ParserEvents;
use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * Class RunParserCommand
 * @package ParserBundle\Command
 */
class RunParserCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('parser:run')
            ->addArgument('name', InputArgument::REQUIRED, 'Name of the Parser')
            ->setDescription('Executes one of the existing parsers.')
        ;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int|null|void
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Start Run Parser Command.');

        $parserLoader = $this->getContainer()->get('parser.loader');
        /** @var ParserInterface $parser */
        $parser = $parserLoader->load($input->getArgument('name'));

        if (!$parser) {
            $output->writeln('No available parsers');

            return;
        }

        $output->writeln('Parser is found. Parsing...');

        $this
            ->getContainer()
            ->get('event_dispatcher')
            ->dispatch(ParserEvents::PARSER_PRE_EXECUTE, new ParserEvent($parser))
        ;

        $parserHandler = $this->getContainer()->get('parser.executor');
        $result = $parserHandler->run($parser);

        $output->writeln(is_null($result) ? 'No subjects has been saved.' : 'Subjects has been saved.');

        $this
            ->getContainer()
            ->get('event_dispatcher')
            ->dispatch(ParserEvents::PARSER_POST_EXECUTE, new ParserEvent($parser))
        ;

        $output->writeln('Finish Run Parser Command.');
    }
}
