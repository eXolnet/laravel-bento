# Laravel Bento

[![Latest Stable Version](https://poser.pugx.org/eXolnet/laravel-bento/v/stable?format=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE)
[![Build Status](https://img.shields.io/github/workflow/status/eXolnet/laravel-bento/tests?label=tests&style=flat-square)](https://github.com/eXolnet/laravel-bento/actions?query=workflow%3Atests)
[![Total Downloads](https://img.shields.io/packagist/dt/eXolnet/laravel-bento.svg?style=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)

Bento helps you organize feature launches by custom user segments.
Create and organize rules to make features available to certain users.

Define your features, define your segmentation strategies and let Bento launch each feature to the right people. Bento can also help you run A/B testing on your applications. 

The core concepts of this library are inspired by [Airbnb's Trebuchet](https://github.com/airbnb/trebuchet) project for Ruby.

## Installation

Require this package with composer:

```bash
composer require eXolnet/laravel-bento
```

After installing Bento, publish its example service provider to hold your feature definitions:

```bash
php artisan vendor:publish --tag=bento-provider
```

Then, add it to the `providers` array in `config/app.php`:

```php
App\Providers\BentoServiceProvider::class
```

## Usage

### Create Features

Define features and their launch segmentation strategies. You can define one strategy with the `feature` method:

```php
Bento::feature('feature')->visitorPercent(10);
```

Or you can combine multiple strategies:

```php
Bento::feature('feature')->visitorPercent(10)->hostname('example.com');
```

Your features could be grouped in the `boot` method of a service provider:

```php
<?php

namespace App\Providers;

use Exolnet\Bento\Facades\Bento;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @return void
     */
    public function boot(): void
    {
        Bento::feature('foo')->everyone();
        Bento::feature('bar')->everyone();
    }
}
```

### Launch Your Features

You can check if a feature is launched for a visitor with the `launch` method:

```php
if (Bento::launch('feature')) {
    //
}
```

Or check that a feature is awaiting launch:

```php
if (Bento::await('feature')) {
    //
}
```

#### Blade

In Blade templates, handy macros are also available:

```
@launch('feature')
    Feature is launched!
@else
    Coming soon!
@endlaunch
```

```
@await('feature')
    Coming soon!
@else
    Feature is launched!
@endawait
```

#### Middleware

Since some strategy requires the request context to be evaluated, it's recommended to use middleware to limit a route:

1. Add the following middleware in the `$routeMiddleware` of your application's HTTP Kernel:

```php
    protected $routeMiddleware = [
        // ...
        'await' => \Exolnet\Bento\Middleware\Await::class,
        'launch' => \Exolnet\Bento\Middleware\Launch::class,
        // ...
    ];
```

2. Then, you could use them to restrict your routes:

```php
Route::middleware('launch:feature')->group(function () {
    //
});
```

```php
Route::middleware('await:feature')->group(function () {
    //
});
```

### Basic Segmentation Strategies

The following segmentation strategies are available to help quickly target your users:

* Callback
* Config
* Date
* Environment
* Everyone
* Guest
* Hostname 
* Nobody
* Stub
* User (authenticated or specific user IDs)
* User Percent (a fraction of all connected visitors)
* Visitor Percent (a fraction of all your visitors)

### Logic Segmentation Strategies

Additional logic segmentation strategies are available to help target your users with more complex rules.

#### Not

```php
Bento::feature('feature')->not->everyone();
```

#### All

```php
use \Exolnet\Bento\Strategy\AimsStrategies;

Bento::feature('feature')->all(function (AimsStrategies $aims) {
    $aims
        ->environment('production')
        ->visitorPercent(20);
});
```

#### Any

```php
use \Exolnet\Bento\Strategy\AimsStrategies;

Bento::feature('feature')->any(function (AimsStrategies $aims) {
    $aims
        ->environment('staging')
        ->user([1, 2]);
});
```

### Custom Segmentation Strategies

You can create custom strategies with dependency injection support similarly to [Laravel Controllers' method injection](https://laravel.com/docs/5.4/controllers#dependency-injection-and-controllers). A common use-case for method injection is injecting the `Illuminate\Contracts\Auth\Guard` instance into your strategy to target users by property:

#### Callback

```php
use Illuminate\Contracts\Auth\Guard;

Bento::feature('feature')->custom(function (Guard $guard, $role) {
    return $guard->user() && $guard->user()->role === 'admin';
});
```

#### Class

```php
use Illuminate\Contracts\Auth\Guard;

class RoleStrategy {
    /**
     * @var \Illuminate\Contracts\Auth\Guard
     */
    protected $guard;
    
    /**
     * @var string 
     */
    protected $role;

    /**
     * @param \Illuminate\Contracts\Auth\Guard $guard
     */
    public function __construct(Guard $guard, string $role)
    {
        $this->guard = $guard;
        $this->role = $role;
    }

    /**
     * @return bool
     */
    public function launch(): bool
    {
        return $this->guard->user() && $this->guard->user()->role === $this->role;
    }
}

Bento::feature('feature')->aim(RoleStrategy::class, 'admin');
```

## Testing

To run the PHPUnit tests, please use:

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) and [CODE OF CONDUCT](CODE_OF_CONDUCT.md) for details.

## Security

If you discover any security related issues, please email security@exolnet.com instead of using the issue tracker.

## Credits

- [Alexandre D'Eschambeault](https://github.com/xel1045)
- [Airbnb Trebuchet](https://github.com/airbnb/trebuchet)
- [All Contributors](../../contributors)

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). Please see the [license file](LICENSE) for more information.
