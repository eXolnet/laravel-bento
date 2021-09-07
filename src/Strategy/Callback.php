<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\StrategyDependencyResolverTrait;
use ReflectionFunction;

class Callback implements Strategy
{
    use StrategyDependencyResolverTrait;

    /**
     * @var callable
     */
    protected $callback;

    /**
     * @var array|null
     */
    protected $parameters = null;

    /**
     * @param callable $callback
     */
    public function __construct(callable $callback)
    {
        $this->callback = $callback;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        if ($this->parameters === null) {
            $this->resolveParameters();
        }

        return call_user_func($this->callback, $this->parameters);
    }

    /**
     * @throws \ReflectionException
     */
    protected function resolveParameters(): void
    {
        $this->parameters = $this->resolveMethodDependencies([], new ReflectionFunction($this->callback));
    }
}
