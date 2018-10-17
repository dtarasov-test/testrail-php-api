<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Users;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 17.10.18
 * Time: 15:57
 */

class UsersTest extends TestCase
{
    /**
     * @var Users
     */
    private $users;

    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->users = new Users($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function all(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_users')
            ->will($this->returnValue([['id' => 1,'name' => 'user1'],['id' => 2,'name' => 'user2']]));

        $this->assertSame([['id' => 1,'name' => 'user1'],['id' => 2,'name' => 'user2']],$this->users->all());
    }

    /**
     * @test
     */
    public function find(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_get')
            ->with('get_users')
            ->will($this->returnValue([['id' => 1,'name' => 'user1','email' => 'user1@web.de'],['id' => 2,'name' => 'user2','email' => 'user2@web.de']]));

        $this->assertSame(['id' => 1,'name' => 'user1','email' => 'user1@web.de'],$this->users->find('user1'));
        $this->assertSame(['id' => 2,'name' => 'user2','email' => 'user2@web.de'],$this->users->find('user2@web.de'));
    }
}