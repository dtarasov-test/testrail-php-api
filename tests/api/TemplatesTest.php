<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Templates;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 18:17
 */

class TemplatesTest extends TestCase
{
    /**
     * @var Templates
     */
    private $templates;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->templates = new Templates($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_templates/1')
            ->will($this->returnValue([['id' => 1,'name' => 'template1'],['id' => 2,'name' => 'template2']]));

        $this->assertSame([['id' => 1,'name' => 'template1'],['id' => 2,'name' => 'template2']],$this->templates->all(1));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_templates/1')
            ->will($this->returnValue([['id' => 1,'name' => 'template1'],['id' => 2,'name' => 'template2']]));

        $this->assertSame(['id' => 2,'name' => 'template2'],$this->templates->findByName(1,'template2'));
    }
}