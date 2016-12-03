<?php
/**
 * Created by PhpStorm.
 * User: gabornagy
 * Date: 2016. 11. 30.
 * Time: 15:44
 */

namespace Example3;

use Example3\Helper\Registry;

class Replacer
{
    protected static $replacement;

    public static function autohelp($string)
    {
        $replacer = self::createReplacement();

        return $replacer->autoHelp($string);
    }

    /**
     * @return ReplacerReplacement
     */
    protected static function createReplacement()
    {
        if (null === self::$replacement) {
            self::$replacement = new ReplacerReplacement();
            self::$replacement->setTagProvider(new TagProvider());
            self::$replacement->setConfig(
                new AutoHelperConfiguration(
                    Registry::getAutohelpStatus(),
                    Registry::getAutohelpWholeWordReplace()
                )
            );
        }

        return self::$replacement;
    }
}