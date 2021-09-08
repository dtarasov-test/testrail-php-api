<?php

use PHPUnit\Framework\TestCase;
use seretos\testrail\api\Results;
use seretos\testrail\connector\ApiConnectorInterface;

/**
 * Created by PhpStorm.
 * User: aappen
 * Date: 04.10.18
 * Time: 17:26
 */

class ResultsTest extends TestCase
{
    /**
     * @var Results
     */
    private $results;
    /**
     * @var ApiConnectorInterface|PHPUnit_Framework_MockObject_MockObject
     */
    private $mockApiConnector;

    protected function setUp(): void
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->results = new Results($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function create(){
        $this->mockApiConnector->expects($this->once())
            ->method('send_post')
            ->with('add_result_for_case/1/2',['status_id' => 3])
            ->will($this->returnValue(['id' => 1,'name' => 'result1']));

        $this->assertSame(['id' => 1,'name' => 'result1'],$this->results->create(1,2,3));
    }
}