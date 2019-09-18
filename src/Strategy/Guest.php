<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Auth\Guard;

class Guest extends Strategy
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     */
    public function __construct(Guard $guard)
    {
        $this->guard = $guard;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        return $this->guard->guest();
    }
}
