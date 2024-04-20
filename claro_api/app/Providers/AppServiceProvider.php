<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Essa\APIToolKit\Exceptions\Handler;
use Illuminate\Contracts\Debug\ExceptionHandler;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(ExceptionHandler::class, Handler::class); // add this line
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
