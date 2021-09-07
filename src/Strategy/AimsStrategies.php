<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\Bento;
use Exolnet\Bento\Feature;

/**
 * @method self all(callable $callback = null)
 * @method self any(callable $callback = null)
 * @method self config(string $key)
 * @method self custom(callable $callback, array $options = [])
 * @method self date(string|int $date, string $operator = '>=')
 * @method self environment(array|string $environments)
 * @method self everyone()
 * @method self guest()
 * @method self hostname(array|string $hostnames)
 * @method self nobody()
 * @method self not(string $name, ...$options)
 * @method self stub(bool $state)
 * @method self user(array|int|null $userIds = null)
 * @method self userPercent(int $percent)
 * @method self visitorPercent(int $percent)
 */
abstract class AimsStrategies implements FeatureAware
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
     * @var array<int, \Exolnet\Bento\Strategy\Strategy>
     */
    protected $strategies = [];

    /**
     * @param \Exolnet\Bento\Bento $bento
     * @param \Exolnet\Bento\Feature $feature
     */
    public function __construct(Bento $bento, Feature $feature)
    {
        $this->bento = $bento;
        $this->feature = $feature;
    }

    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature(): Feature
    {
        return $this->feature;
    }

    /**
     * @return array<int, \Exolnet\Bento\Strategy\Strategy>
     */
    public function getStrategies(): array
    {
        return $this->strategies;
    }

    /**
     * @return int
     */
    public function countStrategies(): int
    {
        return count($this->strategies);
    }

    /**
     * @return bool
     */
    public function hasStrategies(): bool
    {
        return $this->countStrategies() > 0;
    }

    /**
     * @param string $strategy
     * @param ...$options
     * @return $this
     */
    public function aim(string $strategy, ...$options): self
    {
        $this->strategies[] = $this->bento->makeStrategy($this->feature, $strategy, ...$options);

        return $this;
    }

    /**
     * @param string $strategy
     * @param array $options
     * @return $this
     */
    public function __call(string $strategy, array $options): self
    {
        return $this->aim($strategy, ...$options);
    }

    /**
     * @return bool
     */
    abstract public function launch(): bool;
}
