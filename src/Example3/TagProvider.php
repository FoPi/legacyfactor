<?php
namespace Example3;

use Example3\Entity\Tag;
use Example3\Helper\DB;

/**
 * AutoHelpTagProvider
 *
 * @author Fodor Péter
 * @since 2016.12.02. 22:39
 */
class TagProvider
{
    /**
     * @return Tag[]
     */
    public function getTags()
    {
        $tags = [];

        $rows = $this->getTagsFromDB();

        foreach ($rows as $row) {
            $tags[] = new Tag($row["tag"], $row["description"]);
        }

        return $tags;
    }

    /**
     * @return mixed
     */
    public function getTagsFromDB()
    {
        return DB::readAutohelpTags()->rows;
    }
}