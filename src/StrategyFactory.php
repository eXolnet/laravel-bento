<?php namespace Exolnet\Bento;

use Exolnet\Bento\Strategy\Custom;
use Illuminate\Container\Container;
use Illuminate\Routing\RouteDependencyResolverTrait;
use Illuminate\Support\Str;
use InvalidArgumentException;
use ReflectionClass;
use ReflectionFunction;

class StrategyFactory
{
    use RouteDependencyResolverTrait;

    /**
     * @var \Illuminate\Container\Container
     */
    protected $container;

    /**
     * @var array
     */
    protected $customStrategies = [];

    /**
     * @param  \Illuminate\Container\Container  $container
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
    public function make($name, ...$parameters)
    {
        if (isset($this->customStrategies[$name])) {
            return $this->makeCustom($name, $parameters);
        }

        return $this->makeClass($name, $parameters);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Custom
     */
    protected function makeCustom($name, array $parameters)
    {
        $customStrategy = $this->customStrategies[$name];

        $parameters = $this->resolveMethodDependencies($parameters, new ReflectionFunction($customStrategy));

        return new Custom($customStrategy, $parameters);
    }

    /**
     * @param string $name
     * @param array $parameters
     * @return \Exolnet\Bento\Strategy\Strategy
     */
    protected function makeClass($name, array $parameters)
    {
        $className = '\\Exolnet\\Bento\\Strategy\\'. Str::studly($name);

        if (! class_exists($className)) {
            throw new InvalidArgumentException('Could not instantiate strategy with name '. $name);
        }

        $constructor = (new ReflectionClass($className))->getConstructor();

        if ($constructor) {
            $parameters = $this->resolveMethodDependencies($parameters, $constructor);
        }

        return new $className(...$parameters);
    }

    /**
     * @param string $name
     * @param callable $callback
     * @return $this
     */
    public function register($name, callable $callback)
    {
        $this->customStrategies[$name] = $callback;

        return $this;
    }
}
