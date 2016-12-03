<?php
namespace Test\Example1;

use Example1\Filesystem;

/**
 * Class FilesystemTest
 * @package Test\Example1
 */
class FilesystemTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @var Filesystem
     */
    protected $fileSystem;
    public function setUp()
    {
        $this->fileSystem = $this->getMockBuilder(Filesystem::class)
            ->setMethods(['readPath'])
            ->getMock();
    }

    /**
     * @dataProvider dataProvider
     *
     * @param $input
     * @param $expected
     * @param $message
     */
    public function testLowerCase($input, $expected, $message)
    {
        $this->fileSystem
            ->expects($this->once())
            ->method("readPath")
            ->willReturn($input);

        $this->assertEquals($expected, $this->fileSystem->lowerCase(""), $message);
    }

    /**
     * @return array
     */
    public function dataProvider()
    {
        return [
            [[], [], "Empty result"],
            [["testFile.extension"], ["testfile.extension"], "Single result"],
            [
                ["testFile.extension", "testDir/testFile.extension"],
                ["testfile.extension", "testdir/testfile.extension"],
                "Multiple result"
            ]
        ];
    }
}
