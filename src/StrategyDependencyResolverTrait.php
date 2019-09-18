<?php

namespace Exolnet\Bento;

use Illuminate\Support\Arr;
use ReflectionFunctionAbstract;
use ReflectionParameter;

trait StrategyDependencyResolverTrait
{
    /**
     * Resolve the given method's type-hinted dependencies.
     *
     * @param \Exolnet\Bento\Feature $feature
     * @param array $parameters
     * @param \ReflectionFunctionAbstract $reflector
     * @return array
     * @throws \ReflectionException
     */
    protected function resolveMethodDependencies(
        Feature $feature,
        array $parameters,
        ReflectionFunctionAbstract $reflector
    ) {
        $instanceCount = 0;

        $values = array_values($parameters);

        foreach ($reflector->getParameters() as $key => $parameter) {
            $instance = $this->transformDependency($parameter, $feature, $parameters);

            if (! is_null($instance)) {
                $instanceCount++;

                $this->spliceIntoParameters($parameters, $key, $instance);
            } elseif (! isset($values[$key - $instanceCount]) && $parameter->isDefaultValueAvailable()) {
                $this->spliceIntoParameters($parameters, $key, $parameter->getDefaultValue());
            }
        }

        return $parameters;
    }

    /**
     * Attempt to transform the given parameter into a class instance.
     *
     * @param  \ReflectionParameter $parameter
     * @param \Exolnet\Bento\Feature $feature
     * @param  array $parameters
     * @return mixed
     */
    protected function transformDependency(ReflectionParameter $parameter, Feature $feature, array $parameters)
    {
        $class = $parameter->getClass();

        // If the parameter has a type-hinted class, we will check to see if it is already in
        // the list of parameters. If it is we will just skip it as it is probably a model
        // binding and we do not want to mess with those; otherwise, we resolve it here.
        if (! $class || $this->alreadyInParameters($class->name, $parameters)) {
            return null;
        }

        if ($class->getName() === Feature::class) {
            return $feature;
        }

        return $this->container->make($class->name);
    }

    /**
     * Determine if an object of the given class is in a list of parameters.
     *
     * @param  string  $class
     * @param  array  $parameters
     * @return bool
     */
    protected function alreadyInParameters(string $class, array $parameters): bool
    {
        return ! is_null(Arr::first($parameters, function ($value) use ($class) {
            return $value instanceof $class;
        }));
    }

    /**
     * Splice the given value into the parameter list.
     *
     * @param  array  $parameters
     * @param  string  $offset
     * @param  mixed  $value
     * @return void
     */
    protected function spliceIntoParameters(array &$parameters, $offset, $value): void
    {
        array_splice($parameters, $offset, 0, [$value]);
    }
}
