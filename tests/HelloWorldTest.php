<?php

namespace App\Tests;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HelloWorldTest extends WebTestCase
{


    public function dataProvidersUrls()
    {
        return [
            ['/hello',200],
            ['/hello/{name}',200],
            ['/fazfazfazf',404],
        ];
    }

    /**
     * @dataProvider dataProvidersUrls()
     */
    public function testUrls(string $url, int $expectedStatusCode)
    {
        $client = static::createClient();
        $client->request('GET',$url);
        $this->assertSame($expectedStatusCode,$client->getResponse()->getStatusCode());
    }

    public function testInconnu(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello inconnu! ✅');
    }

    public function testPrenom(): void
    {
        $client = static::createClient();
        $crawler = $client->request('GET', '/hello/tony');
        $this->assertResponseIsSuccessful();
        $this->assertSelectorTextContains('h1', 'Hello tony! ✅');
    }


}
