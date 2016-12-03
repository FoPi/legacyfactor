<?php
namespace Example3;

/**
 * AutoHelperConfiguration
 *
 * @author Fodor Péter
 * @since 2016.12.02. 22:35
 */
class AutoHelperConfiguration
{
    /**
     * @var bool
     */
    protected $enabled = false;

    /**
     * @var bool
     */
    protected $wholeWordReplace = false;

    /**
     * AutoHelperConfiguration constructor.
     *
     * @param bool $enabled
     * @param bool $wholeWordReplace
     */
    public function __construct($enabled, $wholeWordReplace)
    {
        $this->enabled = $enabled;
        $this->wholeWordReplace = $wholeWordReplace;
    }

    /**
     * @return boolean
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * @return boolean
     */
    public function isWholeWordReplace()
    {
        return $this->wholeWordReplace;
    }
}