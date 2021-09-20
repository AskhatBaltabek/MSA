<?php

namespace App\Providers;

use App\Models\Notification;
use App\Observers\NotificationObserver;
use Illuminate\Support\ServiceProvider;
use Laravel\Horizon\Horizon;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        Notification::observe(NotificationObserver::class);

        Horizon::auth(function ($request) {
            return true;
        });
    }
}
