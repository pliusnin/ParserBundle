Parsing data from HTML sources
===========================

Using this bundle you can simply configure parser to collect data from websites.

This version is for Symfony 2.8

How to use
-

Install bundle and add to AppKernel class. Create your own Parser class extending \ParserBundle\Model\AbstractParser:

    class MyParser extends AbstractParser
    {
        /**
         * URL which is start page of parsing
         *
         * @return string
         */
        public function getTargetUrl()
        {
            return 'http://newstestsite.com/news/';
        }
    
        /**
         * @param ScenarioBuilder $scenarioBuilder
         * @throws \ParserBundle\Exception\ParserScenarioException
         */
        public function buildScenario(ScenarioBuilder $scenarioBuilder)
        {
            $scenarioBuilder
                ->iterate('.b-news-list-item', 2)
                    ->gotoLink('.b-news-list-image a', 'http://newstestsite.com/news/')
                    ->getText('h1.heading-title', 'title')
                    ->getHtml('article.article', 'text')
                ->endIterate()
            ;
        }
    
        /**
         * @return mixed
         */
        public function createSubjectInstance()
        {
            $news = [];
    
            return $news;
        }
    }
    
Then you have to define service in ```services.yml```

    app.parser.test:
        class: AppBundle\Parser\MyParser
        arguments: ['@doctrine.orm.entity_manager']
        public: true

and config in ```config.yml```

    # ParserBundle configuration
    parser:
        parsers:
            av_by: app.parser.test
            
Run your parser by command ```parser:run NAME```