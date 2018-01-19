<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\Data\UserFixturesData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class HomeControllerTest extends WebTestCase
{
    private $authInfo;

    protected function setUp()
    {
        $testUser = UserFixturesData::$data[0]['firstName'];
        $this->authInfo = [
            'PHP_AUTH_USER' => $testUser,
            'PHP_AUTH_PW' => $testUser,
        ];
    }
    public function testIndex()
    {
        (new \Symfony\Component\Dotenv\Dotenv())->load(__DIR__.'/../../../.env');

        $client = static::createClient();
        $client->setServerParameters($this->authInfo);
        $route = $client->getKernel()->getContainer()->get('router')->generate('home_index');
        $crawler = $client->request('GET', $route);
        $this->assertEquals(200, $client->getResponse()->getStatusCode());
        $this->assertContains(getenv('APP_TITLE'), $crawler->filter('title')->text());
    }
}
