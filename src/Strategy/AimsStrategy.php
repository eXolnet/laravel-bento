<?php

namespace Exolnet\Bento\Strategy;

use Exception;

/**
 * @property-read \Exolnet\Bento\Strategy\HigherOrderNotProxy $not
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
 * @method self not(string $name, ...$options)
 * @method self stub(bool $state)
 * @method self user(array|int|null $userIds = null)
 * @method self userPercent(int $percent)
 * @method self visitorPercent(int $percent)
 */
abstract class AimsStrategy
{
    /**
     * @param string $strategy
     * @param ...$options
     * @return \Exolnet\Bento\Strategy\AimsStrategy
     */
    abstract public function aim(string $strategy, ...$options);

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
            return new HigherOrderNotProxy($this);
        }

        throw new Exception("Property [{$key}] does not exist on this collection instance.");
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
}
