<?php namespace Exolnet\Bento\Strategy;

use Illuminate\Support\Facades\Auth;

class User extends Strategy
{
    /**
     * @var array
     */
    protected $userIds;

    /**
     * @param array|int $userIds
     */
    public function __construct($userIds)
    {
        $this->userIds = (array)$userIds;
    }

    /**
     * @return bool
     */
    public function isLaunched()
    {
        $userId = Auth::id();

        return in_array($userId, $this->userIds);
    }
}
