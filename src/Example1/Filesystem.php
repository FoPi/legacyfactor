<?php

namespace Example1;

/**
 * Created by PhpStorm.
 * User: gabornagy
 * Date: 2016. 11. 30.
 * Time: 13:09
 */
class Filesystem
{
    /**
     * @param $path
     *
     * @return array
     */
    public function lowerCase($path)
    {
        $entries = $this->readPath($path);

        return $this->lowerCaseArrayValues($entries);
    }

    /**
     * @param $path
     *
     * @return array;
     */
    protected function readPath($path)
    {
        return glob($path);
    }

    /**
     * @param $array
     *
     * @return array
     */
    protected function lowerCaseArrayValues($array)
    {
        $lowerCasedArray = [];

        foreach ($array as $item) {
            $lowerCasedArray[] = strtolower($item);
        }

        return $lowerCasedArray;
    }
}