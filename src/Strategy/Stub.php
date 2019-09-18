<?php

namespace Exolnet\Bento\Strategy;

class Stub extends Strategy
{
    /**
     * @var bool
     */
    protected $state;

    /**
     * @param bool $state
     */
    public function __construct(bool $state)
    {
        $this->state = $state;
    }

    /**
     * @return bool
     */
    public function getState(): bool
    {
        return $this->state;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        return $this->state;
    }
}
