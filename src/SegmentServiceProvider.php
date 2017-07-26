<?php namespace Exolnet\Segment;

use Illuminate\Support\ServiceProvider;

class SegmentServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('debugbar', function () {
            return new Segment();
        });
    }
}
