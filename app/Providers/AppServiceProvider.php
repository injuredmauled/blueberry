<?php

namespace App\Providers;

use App\Services\SwitchBot\MakesRequestService as MakesSwitchBotRequestService;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\ServiceProvider;

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
        Http::macro('switch-bot', function () {
            return MakesSwitchBotRequestService::makeRequest();
        });
    }
}
