<?php

namespace Exolnet\Bento\Strategy;

use BadMethodCallException;
use Exception;
use Exolnet\Bento\Feature;
use Exolnet\Bento\StrategyFactory;
use InvalidArgumentException;

/**
 * @property-read \Exolnet\Bento\Strategy\NotHigherOrderProxy $not
 *
 * @method self all(callable $callback = null)
 * @method self any(callable $callback = null)
 * @method self callback(callable $callback)
 * @method self config(string $key)
 * @method self date(string|int $date, string $operator = '>=')
 * @method self environment(array|string $environments)
 * @method self everyone()
 * @method self guest()
 * @method self hostname(array|string $hostnames)
 * @method self nobody()
 * @method self not(callable|string $name, ...$parameters)
 * @method self stub(bool $state)
 * @method self user(array|int|null $userIds = null)
 * @method self userPercent(int $percent)
 * @method self visitorPercent(int $percent)
 */
abstract class AimsStrategy implements FeatureAwareStrategy
{
    /**
     * @var \Exolnet\Bento\Feature|null
     */
    protected $feature;

    /**
     * @return \Exolnet\Bento\Feature
     */
    public function getFeature(): ?Feature
    {
        return $this->feature;
    }

    /**
     * @param  \Exolnet\Bento\Feature $feature
     * @return void
     */
    public function setFeature(Feature $feature): void
    {
        $this->feature = $feature;
    }

    /**
     * @param string $strategy
     * @param ...$parameters
     * @return $this
     */
    abstract public function aim(string $strategy, ...$parameters);

    /**
     * Dynamically access collection proxies.
     *
     * @param  string  $key
     * @return mixed
     *
     * @throws \Exception
     */
    public function __get($key)
    {
        if ($key === 'not') {
            return new NotHigherOrderProxy($this);
        }

        throw new Exception("Property [$key] does not exist on this collection instance.");
    }

    /**
     * @param string $method
     * @param array $parameters
     * @return $this
     */
    public function __call(string $method, array $parameters): self
    {
        try {
            $strategy = $this->makeStrategy($method, $parameters);

            return $this->aim($strategy);
        } catch (InvalidArgumentException $e) {
            throw new BadMethodCallException(
                sprintf('Call to undefined method %s::%s()', static::class, $method)
            );
        }
    }

    /**
     * @param \Exolnet\Bento\Strategy\Strategy|string $strategy
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    protected function makeStrategy($strategy, array $parameters = []): Strategy
    {
        if ($strategy instanceof Strategy) {
            return $strategy;
        }

        return $this->newStrategyFactory()->make($strategy, $parameters);
    }

    /**
     * @return \Exolnet\Bento\StrategyFactory
     */
    protected function newStrategyFactory(): StrategyFactory
    {
        return app(StrategyFactory::class);
    }
}
