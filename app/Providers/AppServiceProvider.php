<?php

namespace App\Providers;

use Carbon\Carbon;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        if ($this->app->environment('local')) {
            $this->app->register(\Laravel\Telescope\TelescopeServiceProvider::class);
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Carbon::macro('inApplicationTimezone', function() {
            return $this->tz(config('app.timezone_display'));
        });
        Carbon::macro('inUserTimezone', function() {
            return $this->tz(auth()->user()?->timezone ?? config('app.timezone_display'));
        });
    }
}
