<?php namespace Exolnet\Bento\Strategy;

class Stub extends Strategy
{
    /**
     * @var bool
     */
    protected $state;

    /**
     * @param bool $state
     */
    public function __construct($state)
    {
        $this->state = (bool)$state;
    }

    /**
     * @return bool
     */
    public function getState()
    {
        return $this->state;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return $this->state;
    }
}
