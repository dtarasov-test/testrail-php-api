<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Configurations;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 11:54
 */

class ConfigurationsTest extends TestCase
{
    /**
     * @var Configurations
     */
    private $configurations;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->configurations = new Configurations($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_configs/1')
            ->will($this->returnValue([['id' => 1,'name' => 'Browsers'],['id' => 2,'name' => 'Operating Systems']]));

        $this->assertSame([['id' => 1,'name' => 'Browsers'],['id' => 2,'name' => 'Operating Systems']],$this->configurations->all(1));
    }

    /**
     * @test
     */
    public function findByGroupName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_configs/1')
            ->will($this->returnValue([['id' => 1,'name' => 'Browsers'],['id' => 2,'name' => 'Operating Systems']]));

        $this->assertSame(['id' => 1,'name' => 'Browsers'],$this->configurations->findByGroupName(1,'Browsers'));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_configs/1')
            ->will($this->returnValue([['id' => 1,'name' => 'Browsers','configs' => [['id' => 1, 'name' => 'firefox'],['id' => 2, 'name' => 'chrome']]],['id' => 2,'name' => 'Operating Systems']]));

        $this->assertSame(['id' => 1, 'name' => 'firefox'],$this->configurations->findByName(1,'Browsers','firefox'));
    }

    /**
     * @test
     */
    public function createGroup(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_config_group/1',['name' => 'Browsers'])->will($this->returnValue(['id' => 1,'name' => 'Browsers']));

        $this->assertSame(['id' => 1,'name' => 'Browsers'],$this->configurations->createGroup(1,'Browsers'));
    }

    /**
     * @test
     */
    public function updateGroup(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_config_group/1',['name' => 'Browsers'])->will($this->returnValue(['id' => 1,'name' => 'Browsers']));

        $this->assertSame(['id' => 1,'name' => 'Browsers'],$this->configurations->updateGroup(1,'Browsers'));
    }

    /**
     * @test
     */
    public function deleteGroup(){
        $this->mockApiConnector->expects($this->once())->method('send_post')->with('delete_config_group/1',[]);

        $this->configurations->deleteGroup(1);
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_config/1',['name' => 'firefox']);

        $this->configurations->create(1,'firefox');
    }

    /**
     * @test
     */
    public function update(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('update_config/1',['name' => 'firefox']);

        $this->configurations->update(1,'firefox');
    }

    /**
     * @test
     */
    public function delete(){
        $this->mockApiConnector->expects($this->once())->method('send_post')->with('delete_config/1',[]);

        $this->configurations->delete(1);
    }
}