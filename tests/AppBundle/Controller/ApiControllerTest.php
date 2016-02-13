<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class ApiControllerTest extends WebTestCase
{
    public function testGetAllOffices()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices');

        $response = $client->getResponse();

        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testGetSpecificOffice()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/1');

        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }

    public function testGetOfficesByCity()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search?city=Gent');

        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }

    public function testGetOfficesWithoutCity()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search');

        $response = $client->getResponse();

        $this->assertEquals(
            400, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testGetOfficesWithCityAndOpenParam()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search?city=Gent&is_open_in_weekends=true');

        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }

    public function testSearchOfficesWithLatWithoutLong()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search?city=Gent&lat=51');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testSearchOfficesWithLongWithoutLat()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search?city=Gent&long=4');

        $response = $client->getResponse();

        $this->assertEquals(400, $response->getStatusCode(), $response->getContent());
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }

    public function testSearchOfficesWithCityLatLong()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search?city=Gent&lat=51.05434220000001&long=3.717424299999948');
        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }

    public function testSearchOfficesWithCityLatLongAndIsOpenInWeekends()
    {
        $client = static::createClient();

        $crawler = $client->request('GET', '/api/v1/offices/search?city=Gent&lat=51.05434220000001&long=3.717424299999948&is_open_in_weekends=true');
        $response = $client->getResponse();

        $this->assertJsonResponse($response);
    }


    protected function assertJsonResponse($response)
    {
        $this->assertEquals(
            200, $response->getStatusCode(),
            $response->getContent()
        );
        $this->assertTrue(
            $response->headers->contains('Content-Type', 'application/json'),
            $response->headers
        );
    }
}