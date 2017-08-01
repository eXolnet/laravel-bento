<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\BentoFacade;

class VisitorPercent extends Percent
{
    /**
     * @return int
     */
    public function getUniqueId()
    {
        return BentoFacade::getVisitorId();
    }
}
