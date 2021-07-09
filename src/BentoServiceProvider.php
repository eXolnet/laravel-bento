<?php

namespace Exolnet\Bento;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class BentoServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = false;

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Blade::directive('launch', function ($expression) {
            return "<?php if (\Exolnet\Bento\Facades\Bento::launch($expression)): ?>";
        });

        Blade::directive('endlaunch', function () {
            return '<?php endif; ?>';
        });

        Blade::directive('await', function ($expression) {
            return "<?php if (\Exolnet\Bento\Facades\Bento::await($expression)): ?>";
        });

        Blade::directive('endawait', function () {
            return '<?php endif; ?>';
        });
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(Bento::class);

        $this->app->alias(Bento::class, 'bento');

        $this->offerPublishing();
    }

    /**
     * @return void
     */
    protected function offerPublishing(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../stubs/BentoServiceProvider.stub' => app_path('Providers/BentoServiceProvider.php'),
            ], 'bento-provider');
        }
    }
}
