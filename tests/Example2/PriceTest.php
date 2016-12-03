<?php
namespace Test;

use Example2\Price;

/**
 * PriceTest
 *
 * @author Fodor Péter
 * @since 2016.12.02. 11:45
 */
class PriceTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Price
     */
    protected $price;

    public function setUp()
    {
        $this->price = $this->getMockBuilder(Price::class)
            ->setMethods(['getTaxRate'])
            ->getMock();
    }

    /**
     * @dataProvider dataProvider
     */
    public function testCalculateGross($input, $return, $expected, $message)
    {
        $price = new Price();

        $price->calculateGross(1);

        $this->price
            ->expects($this->once())
            ->method("getTaxRate")
            ->willReturn($return);

        $this->assertEquals($expected, $this->price->calculateGross($input), $message);
    }

    public function dataProvider()
    {
        return [
            [0, 0, 0, "Zero tax rate"],
            [1, 27, 1.27, "Net: 1, Tax Rate: 27%"],
            [1, 10, 1.10, "Net: 1, Tax Rate: 10%"],
            [20, 27, 25.4, "Net: 20, Tax Rate: 27%"],
            [20, 10, 22, "Net: 20, Tax Rate: 10%"],
        ];
    }
}
