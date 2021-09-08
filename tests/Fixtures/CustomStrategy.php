<?php

namespace Exolnet\Bento\Tests\Fixtures;

use Exolnet\Bento\Strategy\Strategy;

class CustomStrategy implements Strategy
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
    public function launch(): bool
    {
        return $this->state;
    }
}
