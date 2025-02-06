<?php

namespace App\Services\Insurance\ThirdParties;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\InsuranceProvidersEnum;
use App\Enums\ServiceEnum;

interface ProviderInsuranceServiceInterface
{
    public function getService(): ServiceEnum;
    public function getProviders(): InsuranceProvidersEnum;

    public function generateRequest(InsuranceRequestDTO $insuranceRequestDTO);
}