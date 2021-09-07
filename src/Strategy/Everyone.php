<?php

namespace Exolnet\Bento\Strategy;

class Everyone implements Strategy
{
    /**
     * @return bool
     */
    public function launch(): bool
    {
        return true;
    }
}
