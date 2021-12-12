<?php

namespace Rc1021\LaravelAdmin;

use Illuminate\Support\ServiceProvider as OriginServiceProvider;
use Encore\Admin\Form;
use Rc1021\LaravelAdmin\Facades\LineNotify;
use Rc1021\LaravelAdmin\Form\Field\LINENotifyBinder;

class ServiceProvider extends OriginServiceProvider
{
    public function register()
    {
        $this->app->singleton(LineNotify::class, function ($app) {
            return new LINENotifyBinderFactory();
        });
    }

    public function boot()
    {
        // router
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        // langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'line');
        $this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/line'),
        ], 'laravel-admin-line-notify-binder');

        // views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'line');
        $this->publishes([
            __DIR__.'/../resources/views' => resource_path('views/vendor/line'),
        ], 'laravel-admin-line-notify-binder');

        // migrate
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        Form::extend('linenotify', LINENotifyBinder::class);
    }
}
