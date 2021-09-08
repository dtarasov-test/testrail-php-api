<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Cases;
use seretos\testrail\api\Configurations;
use seretos\testrail\api\Fields;
use seretos\testrail\api\Milestones;
use seretos\testrail\api\Plans;
use seretos\testrail\api\Priorities;
use seretos\testrail\api\Projects;
use seretos\testrail\api\Results;
use seretos\testrail\api\Sections;
use seretos\testrail\api\Statuses;
use seretos\testrail\api\Suites;
use seretos\testrail\api\Templates;
use seretos\testrail\api\Types;
use seretos\testrail\api\Users;
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

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();
        $this->client = new Client($this->mockConnector);
    }

    /**
     * @test
     */
    public function getUser(){
        $this->mockConnector->expects($this->once())->method('get_user')->will($this->returnValue('testUser'));

        $this->assertSame('testUser',$this->client->getUser());
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

    /**
     * @test
     */
    public function suites(){
        $this->assertInstanceOf(Suites::class,$this->client->suites());
    }

    /**
     * @test
     */
    public function apiSuites(){
        $this->assertInstanceOf(Suites::class,$this->client->api('suites'));
    }

    /**
     * @test
     */
    public function sections(){
        $this->assertInstanceOf(Sections::class,$this->client->sections());
    }

    /**
     * @test
     */
    public function apiSections(){
        $this->assertInstanceOf(Sections::class,$this->client->api('sections'));
    }

    /**
     * @test
     */
    public function cases(){
        $this->assertInstanceOf(Cases::class,$this->client->cases());
    }

    /**
     * @test
     */
    public function apiCases(){
        $this->assertInstanceOf(Cases::class,$this->client->api('cases'));
    }

    /**
     * @test
     */
    public function templates(){
        $this->assertInstanceOf(Templates::class,$this->client->templates());
    }

    /**
     * @test
     */
    public function apiTemplates(){
        $this->assertInstanceOf(Templates::class,$this->client->api('templates'));
    }

    /**
     * @test
     */
    public function types(){
        $this->assertInstanceOf(Types::class,$this->client->types());
    }

    /**
     * @test
     */
    public function apiTypes(){
        $this->assertInstanceOf(Types::class,$this->client->api('types'));
    }

    /**
     * @test
     */
    public function fields(){
        $this->assertInstanceOf(Fields::class,$this->client->fields());
    }

    /**
     * @test
     */
    public function apiFields(){
        $this->assertInstanceOf(Fields::class,$this->client->api('fields'));
    }

    /**
     * @test
     */
    public function priorities(){
        $this->assertInstanceOf(Priorities::class,$this->client->priorities());
    }

    /**
     * @test
     */
    public function apiPriorities(){
        $this->assertInstanceOf(Priorities::class,$this->client->api('priorities'));
    }

    /**
     * @test
     */
    public function milestones(){
        $this->assertInstanceOf(Milestones::class,$this->client->milestones());
    }

    /**
     * @test
     */
    public function apiMilestones(){
        $this->assertInstanceOf(Milestones::class,$this->client->api('milestones'));
    }

    /**
     * @test
     */
    public function plans(){
        $this->assertInstanceOf(Plans::class,$this->client->plans());
    }

    /**
     * @test
     */
    public function apiPlans(){
        $this->assertInstanceOf(Plans::class,$this->client->api('plans'));
    }

    /**
     * @test
     */
    public function configurations(){
        $this->assertInstanceOf(Configurations::class,$this->client->configurations());
    }

    /**
     * @test
     */
    public function apiConfigurations(){
        $this->assertInstanceOf(Configurations::class,$this->client->api('configurations'));
    }

    /**
     * @test
     */
    public function results(){
        $this->assertInstanceOf(Results::class,$this->client->results());
    }

    /**
     * @test
     */
    public function apiResults(){
        $this->assertInstanceOf(Results::class,$this->client->api('results'));
    }

    /**
     * @test
     */
    public function statuses(){
        $this->assertInstanceOf(Statuses::class,$this->client->statuses());
    }

    /**
     * @test
     */
    public function apiStatuses(){
        $this->assertInstanceOf(Statuses::class,$this->client->api('statuses'));
    }

    /**
     * @test
     */
    public function users(){
        $this->assertInstanceOf(Users::class,$this->client->users());
    }

    /**
     * @test
     */
    public function apiUsers(){
        $this->assertInstanceOf(Users::class,$this->client->api('users'));
    }
}