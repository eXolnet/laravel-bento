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
     * @var array|null
     */
    protected $userIds;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param array|int|null $userIds
     */
    public function __construct(Guard $guard, $userIds = null)
    {
        $this->guard = $guard;

        if ($userIds) {
            $this->userIds = (array)$userIds;
        }
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
        if (! $userId = $this->guard->id()) {
            return false;
        }

        if (! is_array($this->userIds)) {
            return true;
        }

        return in_array($userId, $this->userIds);
    }
}
