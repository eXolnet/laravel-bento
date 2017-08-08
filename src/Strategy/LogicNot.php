<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\BentoFacade;

class LogicNot extends Strategy
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Strategy\Strategy
     */
    protected $strategy;

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param string $name
     * @param array ...$options
     */
    public function __construct(Bento $bento, $name, ...$options)
    {
        $this->bento = $bento;
        $this->strategy = $this->bento->makeStrategy($name, ...$options);
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return ! $this->strategy->launch();
    }
}
