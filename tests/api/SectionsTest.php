<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Sections;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 17:09
 */

class SectionsTest extends TestCase
{
    /**
     * @var Sections
     */
    private $sections;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();
        $this->sections = new Sections($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_sections/1&suite_id=2')
            ->will($this->returnValue([['id' => 1,'name' => 'section1'],['id' => 2,'name' => 'section2']]));

        $this->assertSame([['id' => 1,'name' => 'section1'],['id' => 2,'name' => 'section2']],$this->sections->all(1,2));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_sections/1&suite_id=2')
            ->will($this->returnValue([['id' => 1,'name' => 'section1'],['id' => 2,'name' => 'section2']]));

        $this->assertSame(['id' => 2,'name' => 'section2'],$this->sections->findByName(1,2,'section2'));
    }

    /**
     * @test
     */
    public function findByNameAndParent(){
        $this->mockApiConnector->expects($this->any())
            ->method('send_get')
            ->with('get_sections/1&suite_id=2')
            ->will($this->returnValue([['id' => 1,'name' => 'section1'],['id' => 2,'name' => 'section2','parent_id' => null],['id' => 3,'name' => 'section2','parent_id' => 1]]));

        $this->assertSame(['id' => 3,'name' => 'section2','parent_id' => 1],$this->sections->findByNameAndParent(1,2,'section2',1));
        $this->assertSame(['id' => 2,'name' => 'section2','parent_id' => null],$this->sections->findByNameAndParent(1,2,'section2'));
    }

    /**
     * @test
     */
    public function get(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_section/1')
            ->will($this->returnValue(['id' => 1,'name' => 'section1']));

        $this->assertSame(['id' => 1,'name' => 'section1'],$this->sections->get(1));
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_section/1',['name' => 'mySection','suite_id' => 2,'parent_id'=>null,
                'description' => null])
            ->will($this->returnValue(['id' => 1,'name' => 'mySection']));

        $this->assertSame(['id' => 1,'name' => 'mySection'],$this->sections->create(1, 2,'mySection'));
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_section/1',['name' => 'mySection'])
            ->will($this->returnValue(['id' => 1,'name' => 'mySection']));

        $this->assertSame(['id' => 1,'name' => 'mySection'],$this->sections->update(1,['name' => 'mySection']));
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('delete_section/1',[]);

        $this->sections->delete(1);
    }
}