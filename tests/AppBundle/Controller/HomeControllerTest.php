<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../../../.env');

        $client = static::createClient();
        $route = $client->getKernel()->getContainer()->get('router')->generate('home_index');
        $crawler = $client->request('GET', $route);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(getenv('APP_TITLE'), $crawler->filter('title')->text());
    }
}
