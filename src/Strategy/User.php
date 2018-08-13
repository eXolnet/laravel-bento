<?php

namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Auth\Guard;

class User extends Strategy
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * @var array
     */
    protected $userIds;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param array|int $userIds
     */
    public function __construct(Guard $guard, $userIds)
    {
        $this->userIds = (array)$userIds;
        $this->guard = $guard;
    }

    /**
     * @return array
     */
    public function getUserIds()
    {
        return $this->userIds;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        $userId = $this->guard->id();

        return in_array($userId, $this->userIds);
    }
}
