<?php
namespace Yeganehha\DynamicForms;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use Illuminate\View\Compilers\BladeCompiler;
use Yeganehha\DynamicForms\app\View\Components\fillOutForm;
use Yeganehha\DynamicForms\app\View\Components\makeForm;

class DynamicFormsServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('DynamicForms', function()
        {
            return new DynamicForms();
        });
        $this->app->register(EventServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'migrations');
        $this->loadViewsFrom(__DIR__ . DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'dynamicForms', 'DynamicForms');
        $this->loadRoutesFrom(__DIR__ . DIRECTORY_SEPARATOR.'routes'.DIRECTORY_SEPARATOR.'web.php');
        $this->loadTranslationsFrom(__DIR__.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'lang', 'dynamicForm');
        $this->publishes([
            __DIR__ . DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'dynamicForms' => resource_path('views/vendor/dynamicForms'),
            __DIR__.DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'lang' => resource_path('lang/vendor/dynamicForms'),
            __DIR__.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'migrations' => database_path('migrations'),
        ]);
        $this->configureComponents();
    }

    protected function configureComponents()
    {
        $this->callAfterResolving(BladeCompiler::class, function () {
            Blade::component(fillOutForm::class, 'dynamic-form-fill');
            Blade::component(makeForm::class, 'dynamic-form');
        });
    }
}
