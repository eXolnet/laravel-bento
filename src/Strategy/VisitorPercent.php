<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;

class VisitorPercent extends Percent
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param int $percent
     */
    public function __construct(Bento $bento, $percent)
    {
        parent::__construct($percent);

        $this->bento = $bento;
    }

    /**
     * @return int
     */
    public function getUniqueId()
    {
        return $this->bento->getVisitorId();
    }
}
