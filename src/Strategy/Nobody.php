<?php

namespace Exolnet\Bento\Strategy;

class Nobody implements Strategy
{
    /**
     * @return bool
     */
    public function launch(): bool
    {
        return false;
    }
}
