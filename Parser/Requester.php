<?php
/**
 * Author: Dmitry
 * Date: 19.11.15
 * Time: 22:59
 */

namespace ParserBundle\Parser;

use GuzzleHttp\Client;
use Symfony\Component\DomCrawler\Crawler;

class Requester
{
    /**
     * @var Client
     */
    private $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    /**
     * @param string $url
     * @return Crawler
     */
    public function getHtml($url)
    {
        $response = $this->client->get($url, array());
        $responseHtml = $response->getBody()->getContents();
        $crawler = new Crawler($responseHtml);

        return $crawler;
    }
}
