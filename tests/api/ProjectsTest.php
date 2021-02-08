<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Projects;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 01.10.18
 * Time: 14:28
 */

class ProjectsTest extends TestCase
{
    /**
     * @var Projects
     */
    private $projects;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->projects = new Projects($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_projects')
            ->will($this->returnValue([['id' => 1,'name' => 'testProject'],['id' => 2,'name' => 'testProject2']]));

        $this->assertSame([['id' => 1,'name' => 'testProject'],['id' => 2,'name' => 'testProject2']],$this->projects->all());
    }

    /**
     * @test
     */
    public function get(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_project/1')
            ->will($this->returnValue(['id' => 1,'name' => 'testProject']));

        $this->assertSame(['id' => 1,'name' => 'testProject'],$this->projects->get(1));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_projects')
            ->will($this->returnValue([['id' => 1,'name' => 'testProject'],['id' => 2,'name' => 'testProject2']]));

        $this->assertSame(['id' => 2,'name' => 'testProject2'],$this->projects->findByName('testProject2'));
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_project',['name' => 'myTestProject',
            'announcement' => null,
            'show_announcement' => false,
            'suite_mode' => 3])->will($this->returnValue(['id' => 1,'name' => 'myTestProject']));

        $this->assertSame(['id' => 1,'name' => 'myTestProject'],$this->projects->create('myTestProject'));
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_project/1',['name' => 'myTestProject'])
            ->will($this->returnValue(['id' => 1,'name' => 'myTestProject']));

        $this->assertSame(['id' => 1,'name' => 'myTestProject'],$this->projects->update(1,['name' => 'myTestProject']));
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('delete_project/1',[]);

        $this->projects->delete(1);
    }
}