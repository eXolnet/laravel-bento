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
     * @return array|null
     */
    public function getUserIds(): ?array
    {
        return $this->userIds;
    }

    /**
     * @return bool
     */
    public function launch(): bool
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
