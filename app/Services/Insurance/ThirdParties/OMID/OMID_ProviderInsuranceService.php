<?php

namespace App\Services\Insurance\ThirdParties\OMID;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\InsuranceProvidersEnum;
use App\Enums\InsuranceRequestHolderEnum;
use App\Enums\ServiceEnum;
use App\Exceptions\InsuranceException;
use App\Services\Insurance\ThirdParties\ProviderInsuranceServiceInterface;
use Illuminate\Support\Carbon;

class OMID_ProviderInsuranceService implements ProviderInsuranceServiceInterface
{
    public function generateRequest(InsuranceRequestDTO $insuranceRequestDTO)
    {
        return json_encode($this->mapRequest($insuranceRequestDTO));
    }

    private function mapRequest(InsuranceRequestDTO $dto): array
    {
        try {
            return [
                'company' => [
                    'hasPrevInsurance' => $dto->hasPrevInsurance && $dto->prevInsuranceExpireDate ? Carbon::make($dto->prevInsuranceExpireDate)->isFuture() : false
                ],
                'data' => [
                    'holder' => $dto->holder === InsuranceRequestHolderEnum::CONDUCTOR_PRINCIPAL,
                    'hasSecondDriver' => $dto->hasSecondDriver,
                    'requestDate' => $dto->requestDate->format('Y-m-d'),
                    'prevInsuranceYears' => $dto->prevInsuranceYears,
                    'numDrivers' => $dto->hasSecondDriver ? 1 : 0,
                ]
            ];
        } catch (\Throwable $throwable) {
            throw new InsuranceException($this->getService()->value . ':' . $this->getProviders()->value . ' ' . $throwable->getMessage(), $throwable->getCode(), $throwable);
        }

    }

    public function getProviders(): InsuranceProvidersEnum
    {
        return InsuranceProvidersEnum::OMID;
    }

    public function getService(): ServiceEnum
    {
        return ServiceEnum::INSURANCE;
    }
}