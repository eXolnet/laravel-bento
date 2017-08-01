<?php namespace Exolnet\Bento;

use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;

class BentoServiceProvider extends ServiceProvider
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
        $this->app->singleton('bento', Bento::class);

        $this->registerBladeDirectives();
    }

    /**
     * Register Blade directives.
     *
     * @return void
     */
    protected function registerBladeDirectives()
    {
        $this->app->afterResolving('blade.compiler', function (BladeCompiler $bladeCompiler) {
            $bladeCompiler->directive('launch', function ($expression) {
                return "<?php if (\Exolnet\Bento\BentoFacade::launch($expression)): ?>";
            });

            $bladeCompiler->directive('endlaunch', function () {
                return '<?php endif; ?>';
            });

            $bladeCompiler->directive('unlesslaunch', function ($expression) {
                return "<?php if ( ! \Exolnet\Bento\BentoFacade::launch($expression)): ?>";
            });

            $bladeCompiler->directive('endunlesslaunch', function () {
                return '<?php endif; ?>';
            });
        });
    }
}
