<?php

namespace App\Services\Insurance;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use app\Services\BaseServiceInterface;

interface InsuranceServiceInterface extends BaseServiceInterface {
	public function handleRequest(InsuranceRequestDTO $insuranceRequestDTO);
}
