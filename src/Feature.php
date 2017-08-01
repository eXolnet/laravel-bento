<?php namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\LogicAnd;

class Feature extends LogicAnd
{
    /**
     * @return bool
     */
    public function isLaunched()
    {
        if (! $this->hasStrategies()) {
            return false;
        }

        return parent::isLaunched();
    }
}
