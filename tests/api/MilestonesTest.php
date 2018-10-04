<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Milestones;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 11:18
 */

class MilestonesTest extends TestCase
{
    /**
     * @var Milestones
     */
    private $milestones;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->milestones = new Milestones($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_milestones/1')
            ->will($this->returnValue([['id' => 1,'name' => 'milestone1'],['id' => 2,'name' => 'milestone2']]));

        $this->assertSame([['id' => 1,'name' => 'milestone1'],['id' => 2,'name' => 'milestone2']],$this->milestones->all(1));
    }

    /**
     * @test
     */
    public function get(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_milestone/1')
            ->will($this->returnValue(['id' => 1,'name' => 'milestone1']));

        $this->assertSame(['id' => 1,'name' => 'milestone1'],$this->milestones->get(1));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_milestones/1')
            ->will($this->returnValue([['id' => 1,'name' => 'milestone1'],['id' => 2,'name' => 'milestone2']]));

        $this->assertSame(['id' => 1,'name' => 'milestone1'],$this->milestones->findByName(1,'milestone1'));
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_milestone/1',['name' => 'myMilestone',
                'description' => null,
                'due_on' => 300])->will($this->returnValue(['id' => 1,'name' => 'myMilestone']));

        $mockDateTime = $this->getMockBuilder(DateTime::class)->disableOriginalConstructor()->getMock();
        $mockDateTime->expects($this->once())->method('getTimestamp')->will($this->returnValue(300));

        $this->assertSame(['id' => 1,'name' => 'myMilestone'],$this->milestones->create(1,'myMilestone',null,$mockDateTime));
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_milestone/1',['is_completed' => true])
            ->will($this->returnValue(['id' => 1,'name' => 'myTestProject']));

        $this->assertSame(['id' => 1,'name' => 'myTestProject'],$this->milestones->update(1,['is_completed' => true]));
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('delete_milestone/1',[]);

        $this->milestones->delete(1);
    }
}