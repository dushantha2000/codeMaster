<?php

namespace App\Providers;

use App\Services\SyntaxHighlighter;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(SyntaxHighlighter::class, function () {
            return new SyntaxHighlighter();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
