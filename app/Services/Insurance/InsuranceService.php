<?php

namespace App\Services\Insurance;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\ServiceEnum;
use App\Services\Insurance\ThirdParties\ProviderInsuranceServiceInterface;

class InsuranceService implements InsuranceServiceInterface {

	private ProviderInsuranceServiceInterface $insuranceService;

	public function __construct(
		ProviderInsuranceServiceInterface $insuranceService
	) {
		$this->insuranceService = $insuranceService;
	}

	public function handleRequest(InsuranceRequestDTO $insuranceRequestDTO) {
		return $this->insuranceService->generateRequest($insuranceRequestDTO);
	}

	public function getServiceNameEnum(): ServiceEnum {
		return ServiceEnum::INSURANCE;
	}
}
