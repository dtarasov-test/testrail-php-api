<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Fields;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 02.10.18
 * Time: 10:57
 */

class FieldsTest extends TestCase
{
    /**
     * @var Fields
     */
    private $fields;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->fields = new Fields($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_fields')
            ->will($this->returnValue([['id' => 1,'name' => 'f1','system_name' => 'field1'],['id' => 2,'system_name' => 'field2']]));

        $this->assertSame([['id' => 1,'name' => 'f1','system_name' => 'field1'],['id' => 2,'system_name' => 'field2']],$this->fields->all());
    }

    /**
     * @test
     */
    public function findByProject(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_fields')
            ->will($this->returnValue([['id' => 1,'name' => 'f1','system_name' => 'field1','configs' => [0 => ['context' => ['is_global' => false,'project_ids' => [1,2]]]]],
                ['id' => 2,'name' => 'f2','system_name' => 'field2','configs' => [0 => ['context' => ['is_global' => false,'project_ids' => [3,4]]]]],
                ['id' => 3,'name' => 'f3','system_name' => 'field3','configs' => [0 => ['context' => ['is_global' => true,'project_ids' => null]]]]
            ]));

        $this->assertSame([['id' => 2,'name' => 'f2','system_name' => 'field2','configs' => [0 => ['context' => ['is_global' => false,'project_ids' => [3,4]]]]],
            ['id' => 3,'name' => 'f3','system_name' => 'field3','configs' => [0 => ['context' => ['is_global' => true,'project_ids' => null]]]]],$this->fields->findByProject(3));
    }

    /**
     * @test
     */
    public function findByName(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_fields')
            ->will($this->returnValue([['id' => 1,'name' => 'f1','system_name' => 'field1','configs' => [0 => ['context' => ['is_global' => false,'project_ids' => [1,2]]]]],
                ['id' => 2,'name' => 'f2','system_name' => 'field2','configs' => [0 => ['context' => ['is_global' => false,'project_ids' => [3,4]]]]],
                ['id' => 3,'name' => 'f3','system_name' => 'field3','configs' => [0 => ['context' => ['is_global' => true,'project_ids' => null]]]]
            ]));

        $this->assertSame(['id' => 3,'name' => 'f3','system_name' => 'field3','configs' => [0 => ['context' => ['is_global' => true,'project_ids' => null]]]],$this->fields->findByName('field3'));
    }

    /**
     * @test
     */
    public function findElementId(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_fields')
            ->will($this->returnValue([['id' => 1,'name' => 'f1','system_name' => 'field1','configs' => [0 => ['options' => ['items' => "1, item1
2, item2
3, item3"]]]]]));

        $this->assertSame(2,$this->fields->findElementId('field1','item2'));
    }

    /**
     * @test
     */
    public function findElementNameById(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_case_fields')
            ->will($this->returnValue([['id' => 1,'name' => 'f1','system_name' => 'field1','configs' => [0 => ['options' => ['items' => "1, item1
2, item2
3, item3"]]]]]));

        $this->assertSame('item2',$this->fields->findElementNameById('field1',2));
    }
}