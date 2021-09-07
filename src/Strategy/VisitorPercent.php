<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;

class VisitorPercent extends Percent
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param \Exolnet\Bento\Feature $feature
     * @param int $percent
     */
    public function __construct(Bento $bento, int $percent)
    {
        parent::__construct($percent);

        $this->bento = $bento;
    }

    /**
     * @return int
     */
    public function getUniqueId(): ?int
    {
        return $this->bento->getVisitorId();
    }
}
