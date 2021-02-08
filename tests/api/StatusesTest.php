<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Statuses;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 05.10.18
 * Time: 13:45
 */

class StatusesTest extends TestCase
{
    /**
     * @var Statuses
     */
    private $statuses;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->statuses = new Statuses($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_statuses')
            ->will($this->returnValue([['id' => 1,'name' => 'state1'],['id' => 2,'name' => 'state2']]));

        $this->assertSame([['id' => 1,'name' => 'state1'],['id' => 2,'name' => 'state2']],$this->statuses->all());
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_statuses')
            ->will($this->returnValue([['id' => 1,'name' => 'state1'],['id' => 2,'name' => 'state2']]));

        $this->assertSame(['id' => 2,'name' => 'state2'],$this->statuses->findByName('state2'));
    }
}