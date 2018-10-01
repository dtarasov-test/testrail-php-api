<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Suites;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 15:48
 */

class SuitesTest extends TestCase
{
    /**
     * @var Suites
     */
    private $suites;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->suites = new Suites($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_suites/1')
            ->will($this->returnValue([['id' => 1,'name' => 'testSuite1'],['id' => 2,'name' => 'testSuite2']]));

        $this->assertSame([['id' => 1,'name' => 'testSuite1'],['id' => 2,'name' => 'testSuite2']],$this->suites->all(1));
    }

    /**
     * @test
     */
    public function get(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_suite/1')
            ->will($this->returnValue(['id' => 1,'name' => 'testSuite']));

        $this->assertSame(['id' => 1,'name' => 'testSuite'],$this->suites->get(1));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_suites/1')
            ->will($this->returnValue([['id' => 1,'name' => 'testSuite1'],['id' => 2,'name' => 'testSuite2']]));

        $this->assertSame(['id' => 2,'name' => 'testSuite2'],$this->suites->findByName(1,'testSuite2'));
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_suite/1',['name' => 'myTestSuite',
                'description' => null])
            ->will($this->returnValue(['id' => 1,'name' => 'myTestSuite']));

        $this->assertSame(['id' => 1,'name' => 'myTestSuite'],$this->suites->create(1,'myTestSuite'));
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_suite/1',['name' => 'myTestSuite'])
            ->will($this->returnValue(['id' => 1,'name' => 'myTestSuite']));

        $this->assertSame(['id' => 1,'name' => 'myTestSuite'],$this->suites->update(1,['name' => 'myTestSuite']));
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('delete_suite/1',[]);

        $this->suites->delete(1);
    }
}