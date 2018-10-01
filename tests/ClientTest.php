<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Projects;
use seretos\testrail\Client;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 15:21
 */

class ClientTest extends TestCase
{
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockConnector;
    /**
     * @var Client
     */
    private $client;

    protected function setUp()
    {
        parent::setUp();
        $this->mockConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();
        $this->client = new Client($this->mockConnector);
    }

    /**
     * @test
     */
    public function projects(){
        $this->assertInstanceOf(Projects::class,$this->client->projects());
    }

    /**
     * @test
     */
    public function apiProjects(){
        $this->assertInstanceOf(Projects::class,$this->client->api('projects'));
    }
}