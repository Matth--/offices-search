<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class FormatOfficesTest extends WebTestCase
{
    public function testFormattingOffices()
    {
        $client = static::createClient();
        $container = $client->getContainer();

        $formatOffice = $container->get('app.formatOffices');

        $offices_to_format = array(
            array(
                'city' => 'GENT',
                'street' => 'SINT-PIETERSPLEIN GENT',
            ),
        );

        $formattet_offices = $formatOffice->formatOffices($offices_to_format);
        $this->assertNotNull($formattet_offices);
        $this->assertEquals($formattet_offices, array(
            array(
                'city' => 'Gent',
                'street' => 'Sint-Pietersplein Gent',
            ),
        ));
    }
}