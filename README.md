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
\eXolnet\Bento\BentoServiceProvider::class
```

Finally, add the Facade to the facades array in `config/app.php`: 

```
'Bento' => \eXolnet\Bento\BentoFacade::class
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

Then, you can check if a feature is launched for a visitor with the `isLaunched` method:

```
if (Bento::isLaunched('feature')) {
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

## Testing

To run the phpUnit tests, please use:

``` bash
$ vendor/bin/phpunit -c phpunix.xml
```

## License

This code is licensed under the [MIT license](http://choosealicense.com/licenses/mit/). Please see the [license file](LICENSE) for more information.
