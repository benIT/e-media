<?php

namespace Tests\AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    public function testIndex()
    {
        $client = static::createClient();
        $route = $client->getKernel()->getContainer()->get('router')->generate('home_index');
        $crawler = $client->request('GET', $route);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains($client->getKernel()->getContainer()->getParameter('app_title'), $crawler->filter('title')->text());
//        $this->assertContains($client->getKernel()->getContainer()->getParameter('app_short_title'), $crawler->filter('body')->text());
//        $this->assertContains($client->getKernel()->getContainer()->getParameter('app_slogan'), $crawler->filter('body')->text());
    }
}
