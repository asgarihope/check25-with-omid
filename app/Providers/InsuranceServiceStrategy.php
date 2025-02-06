<?php

namespace App\Providers;

use App\Enums\InsuranceProvidersEnum;
use app\Services\Insurance\InsuranceService;
use app\Services\Insurance\InsuranceServiceInterface;
use App\Services\Insurance\ThirdParties\ACME\ACME_ProviderInsuranceService;
use App\Services\Insurance\ThirdParties\OMID\OMID_ProviderInsuranceService;
use App\Services\Insurance\ThirdParties\ProviderInsuranceServiceInterface;
use Illuminate\Support\ServiceProvider;

class InsuranceServiceStrategy extends ServiceProvider
{

    public function register(): void
    {
        $this->app->bind(InsuranceServiceInterface::class, InsuranceService::class);

        $this->app->bind(ProviderInsuranceServiceInterface::class, function () {
            $providers = [
                InsuranceProvidersEnum::ACME->name => ACME_ProviderInsuranceService::class,
                InsuranceProvidersEnum::OMID->name => OMID_ProviderInsuranceService::class,
            ];

            $selectedProviderKey=config('services.insurance.provider', InsuranceProvidersEnum::ACME->value);
            if (!array_key_exists($selectedProviderKey,$providers)){
                throw new \Exception(trans('validation.in_array',[
                    'attribute'=>'INSURANCE_SERVICE_AVAILABLE in .env',
                    'other'=>join(',',array_keys($providers))
                ]));
            }

            $selectedProvider = $providers[config('services.insurance.provider', InsuranceProvidersEnum::ACME->value)];
            return new $selectedProvider();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
