<?php
/**
 * ClearAdminSoapTest
 *
 * @author Fodor Péter
 * @since 2016.12.02. 14:48
 */

namespace Test\Example4;

use Example4\ClearAdminSoap;
use Example4\Client\CallableClient;

class ClearAdminSoapTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var CallableClient
     */
    protected $callableClient;

    /**
     * @var ClearAdminSoap
     */
    protected $clearAdminSoap;

    public function setUp()
    {
        $this->callableClient = $this->getMockBuilder(CallableClient::class)
            ->setMethods(["call"])
            ->getMock();

        $this->clearAdminSoap = $this->getMockBuilder(ClearAdminSoap::class)
            ->disableOriginalConstructor()
            ->setMethods(["createClient"])
            ->getMock();

        $this->clearAdminSoap
            ->expects($this->once())
            ->method("createClient")
            ->willReturn($this->callableClient);


        $this->clearAdminSoap->__construct();
    }

    public function testAddOssze()
    {
        $this->callableClient
            ->expects($this->once())
            ->method("call")
            ->with(
                'AddOssze',
                [
                    "values" => [
                        "a" => 5,
                        "b" => 5
                    ]
                ]
            )
            ->willReturn($this->returnCallFixture());

        $this->assertEquals(10, $this->clearAdminSoap->addOssze(5, 5));
    }

    private function returnCallFixture()
    {
        return 10;
    }
}
