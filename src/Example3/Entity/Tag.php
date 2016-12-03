<?php
namespace Example3\Entity;

/**
 * Tag
 *
 * @author Fodor Péter
 * @since 2016.12.02. 23:54
 */
class Tag
{
    protected $tag;
    protected $description;

    /**
     * Tag constructor.
     *
     * @param $tag
     * @param $description
     */
    public function __construct($tag, $description)
    {
        $this->tag = $tag;
        $this->description = $description;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @return mixed
     */
    public function getTag()
    {
        return $this->tag;
    }
}