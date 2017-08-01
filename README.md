# Laravel Bento

[![Latest Stable Version](https://poser.pugx.org/eXolnet/laravel-bento/v/stable?format=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/eXolnet/laravel-bento/master.svg?style=flat-square)](https://travis-ci.org/eXolnet/laravel-bento)
[![Total Downloads](https://img.shields.io/packagist/dt/eXolnet/laravel-bento.svg?style=flat-square)](https://packagist.org/packages/eXolnet/laravel-bento)

This project aim to launch features at people. By defining your features and the launch strategies, Bento will take care of enabling the features to the right people. 

The core concepts of this library are based on [Airbnb's Trebuchet](https://github.com/airbnb/trebuchet) project for Ruby.

## Installation

Require this package with composer:

```
composer require eXolnet/laravel-bento
```

After updating composer, add the ServiceProvider to the providers array in `config/app.php`:

```
eXolnet\Bento\BentoServiceProvider::class
```

Finally, add the Facade to the facades array in `config/app.php`: 

```
'Bento' => eXolnet\Bento\BentoFacade::class
```

## Usage

Define features and their launch strategies. You can define one strategy with the `aim` method:

```
Bento::aim('feature', 'visitor-percent', 10);
```

Or you can combine multiple strategies:

```
Bento::feature('feature')->aim('visitor-percent', 10)->aim('hostname', 'example.com');
```

Then, you can check if a feature is launched for a visitor with the `launch` method:

```
if (Bento::launch('feature')) {
    //
}
```

Or use the handy macro in your Blade templates:

```
@launch('feature')
    Feature is launched!
@else
    Coming soon!
@endlaunch
```

### Default Strategies

By default, multiple strategies are available to target your visitors:

* Environment
* Everyone
* Hostname 
* Logic And
* Logic Or
* Logic Not
* Nobody
* User (specific user IDs)
* User Percent (a fraction of all connected visitors)
* Visitor Percent (a fraction of all your visitors)

### Logic Strategies

You can aim your visitor with more complex rules using the logic strategies:

#### Logic Not

```
Bento::aim('feature', 'logic-not', 'everybody');
```

#### Logic And

```
Bento::aim('feature', 'logic-and', function($feature) {
    $feature
        ->aim('environment', 'production')
        ->aim('visitor-percent', 20);
});
```

#### Logic Or

```
Bento::aim('feature', 'logic-or', function($feature) {
    $feature
        ->aim('environment', 'staging')
        ->aim('user', [1, 2]);
});
```

### Custom Strategies

You can also define your own custom strategies like so:

```
Bento::defineStrategy('role', function($role) {
    return Auth::user() && Auth::user()->role === $role;
});
```

Then, you can use your custom strategy like the default one:

```
Bento::feature('feature')->aim('role', 'admin');
```


## Testing

To run the phpUnit tests, please use:

``` bash
$ composer test
```

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email adeschambeault@exolnet.com instead of using the issue tracker.

## Credits

- [Alexandre D'Eschambeault](https://github.com/xel1045)
- [Airbnb Trebuchet](https://github.com/airbnb/trebuchet)
- [All Contributors](../../contributors)

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). Please see the [license file](LICENSE) for more information.
