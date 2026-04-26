<?php

namespace App\Providers;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        Auth::provider('custom_file', function (Application $app, array $config) {
            return new TextFileUserProvider();
        });
    }

    public function boot(): void
    {
        //
    }
}
