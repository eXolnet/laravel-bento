<?php namespace Exolnet\Bento\Strategy;

class LogicAnd extends Logic
{
    /**
     * @return bool
     */
    public function isLaunched()
    {
        /** @var \Exolnet\Bento\Strategy\Strategy $strategy */
        foreach ($this->strategies as $strategy) {
            if ( ! $strategy->isLaunched()) {
                return false;
            }
        }

        return true;
    }
}
