<?php
namespace Test\Example3;

use Example3\AutoHelperConfiguration;
use Example3\ReplacerReplacement;
use Example3\TagProvider;

/**
 * ReplacerTest
 *
 * @author Fodor Péter
 * @since 2016.12.02. 21:33
 */
class ReplacerTest extends \PHPUnit_Framework_TestCase
{
    protected $tagProvider;
    /**
     * @var AutoHelperConfiguration
     */
    protected $config;

    /**
     * @var ReplacerReplacement
     */
    protected $replacer;

    protected function setUp()
    {
        $this->tagProvider = $this->getMockBuilder(TagProvider::class)
            ->setMethods(["getTagsFromDB"])
            ->getMock();

        $this->tagProvider
            ->method("getTagsFromDB")
            ->willReturn(
                [
                    ['tag' => 'dummy', 'description' => 'this is a dummy description'],
                    ['tag' => 'Lorem', 'description' => 'Donec eget condimentum'],
                    ['tag' => 'ipsum', 'description' => 'consectetur pellentesque lacus'],
                    ['tag' => 'sum', 'description' => 'Cras orci lacus, mattis eget dignissim non'],
                ]
            );

    }

    public function testDisabledAuthelp()
    {
        $config = new AutoHelperConfiguration(false, false);
        $replacer = new ReplacerReplacement($this->tagProvider, $config);

        $string = "dummy";

        $this->assertEquals($string, $replacer->autohelp($string));
    }


    /**
     * @dataProvider dataProviderForDisabledWholeWordConfig
     *
     * @param $expected
     * @param $input
     * @param $message
     */
    public function testWithDisabledWholeWord($expected, $input, $message)
    {
        $config = new AutoHelperConfiguration(true, false);
        $replacer = new ReplacerReplacement($this->tagProvider, $config);

        $this->assertEquals($expected, $replacer->autohelp($input), $message);
    }

    /**
     * @return array
     */
    public function dataProviderForDisabledWholeWordConfig()
    {
        return [
            [null, "", "Empty string"],
            ["<dummy>asdadas</dummy>", "<dummy>asdadas</dummy>", "Not matching text"],
            [
                "<span> <span class=\"autohelp\" title=\"this is a dummy description\">dummy</span> </span>",
                "<span> dummy </span>",
                "Matching single text wrapped with spaces"
            ],
            [
                "<span><span class=\"autohelp\" title=\"this is a dummy description\">dummy</span></span><span class=\"autohelp\" title=\"consectetur pellentesque lacus\">ipsum</span>",
                "<span>dummy</span>ipsum",
                "Matching multiple text with word boundary"
            ],
            [
                "<span>asd<span class=\"autohelp\" title=\"this is a dummy description\">dummy</span><span class=\"autohelp\" title=\"consectetur pellentesque lacus\">ipsum</span></span>",
                "<span>asddummyipsum</span>",
                "Matching multiple text without word boundary"
            ],
        ];
    }

    /**
     * @dataProvider dataProviderForFullyEnabledConfig
     *
     * @param $expected
     * @param $input
     * @param $message
     */
    public function testAutoHelpEnabledAndWholeWord($expected, $input, $message)
    {
        $config = new AutoHelperConfiguration(true, true);
        $replacer = new ReplacerReplacement($this->tagProvider, $config);

        $this->assertEquals($expected, $replacer->autoHelp($input), $message);
    }

    /**
     * @return array
     */
    public function dataProviderForFullyEnabledConfig()
    {
        return [
            [null, "", "Empty string"],
            ["<dummy>asdadas</dummy>", "<dummy>asdadas</dummy>", "Not matching text"],
            [
                "<span> <span class=\"autohelp\" title=\"this is a dummy description\">dummy</span> </span>",
                "<span> dummy </span>",
                "Matching single text wrapped with spaces"
            ],
            [
                "<span><span class=\"autohelp\" title=\"this is a dummy description\">dummy</span></span><span class=\"autohelp\" title=\"consectetur pellentesque lacus\">ipsum</span>",
                "<span>dummy</span>ipsum",
                "Matching multiple text with word boundary"
            ],
            [
                "<span>asddummyipsum</span>",
                "<span>asddummyipsum</span>",
                "Matching multiple text without word boundary"
            ],
        ];
    }
}
