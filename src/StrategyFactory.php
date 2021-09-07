<?php

namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\Strategy;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;

class StrategyFactory
{
    use StrategyDependencyResolverTrait;

    /**
     * @var \Illuminate\Contracts\Container\Container
     */
    protected $container;

    /**
     * @param \Illuminate\Contracts\Container\Container $container
     */
    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    public function make(string $name, array $parameters = []): Strategy
    {
        $className = '\\Exolnet\\Bento\\Strategy\\' . Str::studly($name);

        if (! class_exists($className)) {
            throw new InvalidArgumentException('Could not instantiate strategy with name ' . $name);
        }

        $constructor = (new ReflectionClass($className))->getConstructor();

        if ($constructor) {
            $parameters = $this->resolveMethodDependencies($parameters, $constructor);
        }

        return new $className(...$parameters);
    }
}
