<?php

namespace App\Providers;

use App\Facades\FilterEvent;
use App\Services\Contracts\EventContract;
use App\Services\Repositories\EventService;
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
        $this->app->bind(EventContract::class, EventService::class);
        $this->app->bind('FilterEvent', function(){
            return new FilterEvent();
        });
    
        
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    }
        
}
