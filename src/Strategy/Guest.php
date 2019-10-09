<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Auth\Factory as Auth;

class Guest extends Strategy
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * @param \Illuminate\Contracts\Auth\Factory $auth
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        return $this->auth->guard()->guest();
    }
}
