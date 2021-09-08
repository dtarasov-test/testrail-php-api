<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Priorities;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 02.10.18
 * Time: 14:30
 */

class PrioritiesTest extends TestCase
{
    /**
     * @var Priorities
     */
    private $priorities;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->priorities = new Priorities($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_priorities')
            ->will($this->returnValue([['id' => 1,'name' => 'prio1'],['id' => 2,'name' => 'prio2']]));

        $this->assertSame([['id' => 1,'name' => 'prio1'],['id' => 2,'name' => 'prio2']],$this->priorities->all());
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_priorities')
            ->will($this->returnValue([['id' => 1,'name' => 'prio1'],['id' => 2,'name' => 'prio2']]));

        $this->assertSame(['id' => 1,'name' => 'prio1'],$this->priorities->findByName('prio1'));
    }

    /**
     * @test
     */
    public function getDefaultPriority(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_priorities')
            ->will($this->returnValue([['id' => 1,'name' => 'prio1','is_default' => false],['id' => 2,'name' => 'prio2','is_default' => true]]));
        $this->assertSame(['id' => 2,'name' => 'prio2','is_default' => true],$this->priorities->getDefaultPriority());
    }
}