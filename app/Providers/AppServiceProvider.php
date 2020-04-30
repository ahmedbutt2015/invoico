<?php

namespace App\Providers;

use App\Notification;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

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

        view()->composer('*', function ($view)
        {
            $notifications = Notification::where('user_id',auth()->id())->where('read',0)->orderBy('id','desc')->get();

            $view->with('notifications', $notifications);
        });
    }
}
