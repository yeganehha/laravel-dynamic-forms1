<?php
namespace Yeganehha\DynamicForms;

use Illuminate\Support\ServiceProvider;

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
        $this->publishes([
            __DIR__.DIRECTORY_SEPARATOR.'Database'.DIRECTORY_SEPARATOR.'migrations' => database_path('migrations/vendor/dynamicForms'),
            __DIR__ . DIRECTORY_SEPARATOR.'resources'.DIRECTORY_SEPARATOR.'views'.DIRECTORY_SEPARATOR.'dynamicForms' => resource_path('views/vendor/dynamicForms')
        ]);
    }
}
