<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Feature;
use InvalidArgumentException;

class Not extends AimsStrategy implements Strategy
{
    /**
     * @var \Exolnet\Bento\Strategy\Strategy
     */
    protected $strategy;

    /**
     * @param callable|string $strategy
     * @param ...$parameters
     */
    public function __construct($strategy, ...$parameters)
    {
        if (is_callable($strategy)) {
            $strategy($this);
        } else {
            $this->aim($strategy, ...$parameters);
        }
    }

    /**
     * @param \Exolnet\Bento\Feature $feature
     */
    public function setFeature(Feature $feature): void
    {
        parent::setFeature($feature);

        if ($this->strategy instanceof FeatureAwareStrategy) {
            $this->strategy->setFeature($feature);
        }
    }


    /**
     * @param \Exolnet\Bento\Strategy\Strategy|string $strategy
     * @param mixed ...$parameters
     * @return $this
     */
    public function aim($strategy, ...$parameters): self
    {
        $this->strategy = $this->makeStrategy($strategy, $parameters);

        return $this;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        if (! $this->strategy) {
            throw new InvalidArgumentException('Not strategy is defined without any strategy');
        }

        return ! $this->strategy->launch();
    }
}
