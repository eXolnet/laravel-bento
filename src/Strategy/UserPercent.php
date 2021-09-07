<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;
use Illuminate\Contracts\Auth\Factory as Auth;

class UserPercent extends Percent
{
    /**
     * @var \Illuminate\Contracts\Auth\Factory
     */
    protected $auth;

    /**
     * @param \Exolnet\Bento\Feature $feature
     * @param \Illuminate\Contracts\Auth\Factory $auth
     * @param int $percent
     */
    public function __construct(Feature $feature, Auth $auth, int $percent)
    {
        parent::__construct($feature, $percent);

        $this->auth = $auth;
    }

    /**
     * @return int|null
     */
    public function getUniqueId(): ?int
    {
        return $this->auth->guard()->id();
    }
}
