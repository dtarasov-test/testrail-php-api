<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Types;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 18:21
 */

class TypesTest extends TestCase
{
    /**
     * @var Types
     */
    private $types;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->types = new Types($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_types')
            ->will($this->returnValue([['id' => 1,'name' => 'type1'],['id' => 2,'name' => 'type2']]));

        $this->assertSame([['id' => 1,'name' => 'type1'],['id' => 2,'name' => 'type2']],$this->types->all());
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_types')
            ->will($this->returnValue([['id' => 1,'name' => 'type1'],['id' => 2,'name' => 'type2']]));

        $this->assertSame(['id' => 2,'name' => 'type2'],$this->types->findByName('type2'));
    }
}