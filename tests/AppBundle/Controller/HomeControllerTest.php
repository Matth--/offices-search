<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class HomeControllerTest extends WebTestCase
{
    public function testShowHomePage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("show offices in the neighborhood of:")')->count()
        );
    }

    public function testShowDocsPage()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/doc');

        $this->assertGreaterThan(
            0,
            $crawler->filter('html:contains("API documentation")')->count()
        );
    }
}