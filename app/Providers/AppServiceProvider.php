<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;   // ← این خط مهم است

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
        // ← این خط مشکل طول کلید MySQL را برای همیشه حل می‌کنه
        Schema::defaultStringLength(191);
    }
}