<?php

namespace Exolnet\Bento\Strategy;

class Nobody extends Strategy
{
    /**
     * @return bool
     */
    public function launch(): bool
    {
        return false;
    }
}
