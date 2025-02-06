<?php

namespace App\Services\Insurance\ThirdParties\ACME;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\InsuranceProvidersEnum;
use App\Enums\InsuranceRequestHolderEnum;
use App\Enums\ServiceEnum;
use App\Exceptions\InsuranceException;
use App\Services\Insurance\ThirdParties\ProviderInsuranceServiceInterface;
use Illuminate\Support\Carbon;
use Spatie\ArrayToXml\ArrayToXml;

class ACME_ProviderInsuranceService implements ProviderInsuranceServiceInterface
{
    public function generateRequest(InsuranceRequestDTO $insuranceRequestDTO)
    {
        return ArrayToXml::convert(
            $this->mapRequest($insuranceRequestDTO),
            'TarificacionThirdPartyRequest'
        );
    }

    public function mapRequest(InsuranceRequestDTO $dto): array
    {
        try {
            return [
                'Datos' => [
                    'DatosAseguradora' => [
                        'SeguroEnVigor' => $this->transformBooleanValue($dto->hasPrevInsurance && $dto->prevInsuranceExpireDate ? Carbon::make($dto->prevInsuranceExpireDate)->isFuture() : false)
                    ],
                    'DatosGenerales' => [
                        'CondPpalEsTomador' => $this->transformBooleanValue($dto->holder === InsuranceRequestHolderEnum::CONDUCTOR_PRINCIPAL), // S
                        'ConductorUnico' => $this->transformBooleanValue($dto->hasSecondDriver), //S
                        'FecCot' => $dto->requestDate->toIso8601String(), //2020-06-14T00:00:00
                        'AnosSegAnte' => $dto->prevInsuranceYears, //3
                        'NroCondOca' => $dto->hasSecondDriver ? 1 : 0,//0
                    ]
                ]
            ];
        } catch (\Throwable $throwable) {
            throw new InsuranceException($this->getService()->value . ':' . $this->getProviders()->value . ' ' . $throwable->getMessage(), $throwable->getCode(), $throwable);
        }

    }

    private function transformBooleanValue(bool $attribute): string
    {
        return $attribute ? 'S' : 'N';
    }


    public function getProviders(): InsuranceProvidersEnum
    {
        return InsuranceProvidersEnum::ACME;
    }


    public function getService(): ServiceEnum
    {
        return ServiceEnum::INSURANCE;
    }
}