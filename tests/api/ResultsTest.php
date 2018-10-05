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

    protected function setUp()
    {
        parent::setUp();
        $this->mockApiConnector = $this->getMockBuilder(ApiConnectorInterface::class)->disableOriginalConstructor()->getMock();

        $this->results = new Results($this->mockApiConnector);
    }

    /**
     * @test
     */
    public function test(){
        $this->assertSame('tst','tst');
    }
}