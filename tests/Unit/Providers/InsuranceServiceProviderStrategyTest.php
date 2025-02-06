<?php

namespace Tests\Unit\Providers;

use App\Enums\InsuranceProvidersEnum;
use App\Providers\InsuranceServiceStrategy;
use App\Services\Insurance\ThirdParties\ACME\ACME_ProviderInsuranceService;
use App\Services\Insurance\ThirdParties\OMID\OMID_ProviderInsuranceService;
use App\Services\Insurance\ThirdParties\ProviderInsuranceServiceInterface;
use Exception;
use Illuminate\Support\Facades\Config;
use Tests\TestCase;

class InsuranceServiceProviderStrategyTest extends TestCase
{

    public function test_acme_provider_is_bound_by_default()
    {
        config(['services.insurance.provider' => InsuranceProvidersEnum::ACME->value]);

        $this->app->register(InsuranceServiceStrategy::class);

        $service = $this->app->make(ProviderInsuranceServiceInterface::class);
        $this->assertInstanceOf(ACME_ProviderInsuranceService::class, $service);
    }

    public function test_omid_provider_is_bound_when_configured()
    {
        Config::set('services.insurance.provider', InsuranceProvidersEnum::OMID->value);

        $this->app->register(InsuranceServiceStrategy::class);

        $service = $this->app->make(ProviderInsuranceServiceInterface::class);
        $this->assertInstanceOf(OMID_ProviderInsuranceService::class, $service);
    }

    public function test_exception_is_thrown_for_invalid_provider()
    {
        Config::set('services.insurance.provider', 'INVALID_PROVIDER');

        $this->expectException(Exception::class);
        $this->expectExceptionMessageMatches('/INSURANCE_SERVICE_AVAILABLE in .env/');

        $this->app->register(InsuranceServiceStrategy::class);
        $this->app->make(ProviderInsuranceServiceInterface::class);
    }
}
