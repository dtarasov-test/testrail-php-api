<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Cases;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 18:09
 */

class CasesTest extends TestCase
{
    /**
     * @var Cases
     */
    private $cases;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->cases = new Cases($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_cases/1&suite_id=2&section_id=3')
            ->will($this->returnValue([['id' => 1,'name' => 'case1'],['id' => 2,'name' => 'case2']]));

        $this->assertSame([['id' => 1,'name' => 'case1'],['id' => 2,'name' => 'case2']],$this->cases->all(1,2,3));
    }

    /**
     * @test
     */
    public function findBySection(){
        $this->mockApiConnector->expects($this->exactly(2))
            ->method('send_get')
            ->withConsecutive(
                [
                    'get_cases/1&suite_id=2&section_id=3',
                ],
                [
                    'get_cases/1&suite_id=2&section_id=',
                ]
            )
            ->willReturnOnConsecutiveCalls(
                [
                    ['id' => 1,'name' => 'case1','section_id' => null],
                    ['id' => 2,'name' => 'case2','section_id' => null],
                    ['id' => 3,'name' => 'case2','section_id' => 3],
                ],
                [
                    ['id' => 1,'name' => 'case1','section_id' => null],
                    ['id' => 2,'name' => 'case2','section_id' => null],
                    ['id' => 3,'name' => 'case2','section_id' => 3],
                ]
            );

        $this->assertSame([['id' => 3,'name' => 'case2','section_id' => 3]],$this->cases->findBySection(1,2,3));
        $this->assertSame([['id' => 1,'name' => 'case1','section_id' => null],['id' => 2,'name' => 'case2','section_id' => null]],$this->cases->findBySection(1,2));
    }

    /**
     * @test
     */
    public function findByTitle(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_cases/1&suite_id=2&section_id=3')
            ->will($this->returnValue([['id' => 1,'title' => 'case1'],['id' => 2,'title' => 'case2']]));

        $this->assertSame(['id' => 2,'title' => 'case2'],$this->cases->findByField(1,2,'title','case2',3));
    }

    /**
     * @test
     */
    public function get(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case/1')
            ->will($this->returnValue(['id' => 1,'name' => 'case1']));

        $this->assertSame(['id' => 1,'name' => 'case1'],$this->cases->get(1));
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_case/1',['title' => 'myCase','template_id' => 2,'type_id'=>3])
            ->will($this->returnValue(['id' => 1,'name' => 'myCase']));

        $this->assertSame(['id' => 1,'name' => 'myCase'],$this->cases->create(1, 'myCase',2,3));
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_case/1',['title' => 'myCase'])
            ->will($this->returnValue(['id' => 1,'title' => 'myCase']));

        $this->assertSame(['id' => 1,'title' => 'myCase'],$this->cases->update(1,['title' => 'myCase']));
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('delete_case/1',[]);

        $this->cases->delete(1);
    }
}