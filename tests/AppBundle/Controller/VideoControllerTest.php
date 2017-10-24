<?php

namespace Tests\AppBundle\Controller;

use AppBundle\DataFixtures\ORM\Data\UserFixturesData;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Symfony\Component\HttpFoundation\Response;

class VideoControllerTest extends WebTestCase
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
        $client = static::createClient();

        $route = $client->getKernel()->getContainer()->get('router')->generate('video_index');
        $client->request('GET', $route);
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $client->setServerParameters($this->authInfo);

        $client->request('GET', $route);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }

    public function testShow()
    {
        $client = static::createClient();

        $route = $client->getKernel()->getContainer()->get('router')->generate('video_show', ['id' => 1]);
        $client->request('GET', $route);
        $this->assertEquals(Response::HTTP_FOUND, $client->getResponse()->getStatusCode());

        $client->setServerParameters($this->authInfo);

        $client->request('GET', $route);
        $this->assertEquals(Response::HTTP_OK, $client->getResponse()->getStatusCode());
    }
}
