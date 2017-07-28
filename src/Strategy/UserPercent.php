<?php namespace Exolnet\Bento\Strategy;

use Illuminate\Support\Facades\Auth;

class UserPercent extends Percent
{
    /**
     * @return int
     */
    public function getUniqueId()
    {
        return Auth::id();
    }
}
