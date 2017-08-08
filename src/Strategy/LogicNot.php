<?php namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;

class LogicNot extends Strategy implements FeatureAware
{
    /**
     * @var \Exolnet\Bento\Bento
     */
    protected $bento;

    /**
     * @var \Exolnet\Bento\Feature
     */
    protected $feature;

    /**
     * @var \Exolnet\Bento\Strategy\Strategy
     */
    protected $strategy;

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param \Exolnet\Bento\Feature $feature
     * @param string $name
     * @param array ...$options
     */
    public function __construct(Bento $bento, Feature $feature, $name, ...$options)
    {
        $this->bento = $bento;
        $this->feature = $feature;
        $this->strategy = $this->bento->makeStrategy($this->feature, $name, ...$options);
    }

    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature()
    {
        return $this->feature;
    }

    /**
     * @return bool
     */
    public function launch()
    {
        return ! $this->strategy->launch();
    }
}
