<?php

namespace Exolnet\Bento\Strategy;

use Exolnet\Bento\StrategyDependencyResolverTrait;
use Illuminate\Contracts\Container\Container;
use ReflectionFunction;

class Callback implements Strategy
{
    use StrategyDependencyResolverTrait;

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

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
    public function __construct(Container $container, callable $callback)
    {
        $this->container = $container;
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

        return call_user_func_array($this->callback, $this->parameters);
    }

    /**
     * @throws \ReflectionException
     */
    protected function resolveParameters(): void
    {
        $this->parameters = $this->resolveMethodDependencies([], new ReflectionFunction($this->callback));
    }
}
