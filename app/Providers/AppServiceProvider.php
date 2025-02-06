<?php

namespace App\Providers;

use app\Services\BaseService;
use app\Services\BaseServiceInterface;
use App\Services\Insurance\InsuranceService;
use App\Services\Insurance\InsuranceServiceInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BaseServiceInterface::class, BaseService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
