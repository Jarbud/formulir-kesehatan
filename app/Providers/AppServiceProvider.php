<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\URL;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
        // if (str_contains(request()->getHttpHost(), 'ngrok-free.app')) {
        //     URL::forceScheme('https');
        // }
        // Paksa semua URL asset & route menggunakan HTTPS jika diakses lewat Ngrok
        if (str_contains(request()->getHost(), 'ngrok') || request()->header('X-Forwarded-Proto') === 'https') {
            \Illuminate\Support\Facades\URL::forceScheme('https');
        }
    }
}
