<?php namespace Exolnet\Bento\Strategy;

use Illuminate\Contracts\Auth\Guard;
use Illuminate\Support\Facades\Auth;

class UserPercent extends Percent
{
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     * @param int $percent
     */
    public function __construct(Guard $guard, $percent)
    {
        parent::__construct($percent);

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
