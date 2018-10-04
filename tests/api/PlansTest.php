<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Plans;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 11:29
 */

class PlansTest extends TestCase
{
    /**
     * @var Plans
     */
    private $plans;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->plans = new Plans($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_plans/1')
            ->will($this->returnValue([['id' => 1,'name' => 'plan1'],['id' => 2,'name' => 'plan2']]));

        $this->assertSame([['id' => 1,'name' => 'plan1'],['id' => 2,'name' => 'plan2']],$this->plans->all(1));
    }

    /**
     * @test
     */
    public function get(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_plan/1')
            ->will($this->returnValue(['id' => 1,'name' => 'milestone1']));

        $this->assertSame(['id' => 1,'name' => 'milestone1'],$this->plans->get(1));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_plans/1')
            ->will($this->returnValue([['id' => 1,'name' => 'plan1'],['id' => 2,'name' => 'plan2']]));

        $this->assertSame(['id' => 1,'name' => 'plan1'],$this->plans->findByName(1,'plan1'));
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_plan/1',['name' => 'myPlan',
                'description' => null,
                'milestone_id' => null])->will($this->returnValue(['id' => 1,'name' => 'myPlan']));

        $this->assertSame(['id' => 1,'name' => 'myPlan'],$this->plans->create(1,'myPlan'));
    }

    /**
     * @test
     */
    public function createEntry(){
        $this->mockApiConnector->expects($this->once())->method('send_post')
            ->with('add_plan_entry/1',['suite_id' => 1, 'name' => 'test', 'description' => null, 'include_all' => true,'case_ids' => [],'config_ids' => [],'runs' => []])
            ->will($this->returnValue(['id' => 1,'name' => 'myPlanEntry']));

        $this->assertSame(['id' => 1,'name' => 'myPlanEntry'],$this->plans->createEntry(1,1,'test'));
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_plan/1',['name' => 'myPlan'])
            ->will($this->returnValue(['id' => 1,'name' => 'myPlan']));

        $this->assertSame(['id' => 1,'name' => 'myPlan'],$this->plans->update(1,['name' => 'myPlan']));
    }

    /**
     * @test
     */
    public function updateEntry(){
        $this->mockApiConnector->expects($this->once())->method('send_post')->with('update_plan_entry/1/2',['name' => 'myPlanEntry'])->will($this->returnValue(['id' => 1,'name' => 'myPlanEntry']));

        $this->assertSame(['id' => 1,'name' => 'myPlanEntry'],$this->plans->updateEntry(1,2,['name' => 'myPlanEntry']));
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('delete_plan/1',[]);

        $this->plans->delete(1);
    }

    /**
     * @test
     */
    public function deleteEntry(){
        $this->mockApiConnector->expects($this->once())->method('send_post')->with('delete_plan_entry/1/2',[]);
        $this->plans->deleteEntry(1,2);
    }

    /**
     * @test
     */
    public function close(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('close_plan/1',[])->will($this->returnValue(['id' => 1,'name'=>'myPlan']));

        $this->assertSame(['id' => 1,'name'=>'myPlan'],$this->plans->close(1));
    }
}