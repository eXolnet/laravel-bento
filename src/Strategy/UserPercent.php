<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;
use Illuminate\Contracts\Auth\Guard;

class UserPercent extends Percent
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param \Exolnet\Bento\Feature $feature
     * @param int $percent
     */
    public function __construct(Feature $feature, Guard $guard, $percent)
    {
        parent::__construct($feature, $percent);

        $this->guard = $guard;
    }

    /**
     * @return int
     */
    public function getUniqueId()
    {
        return $this->guard->id();
    }
}
