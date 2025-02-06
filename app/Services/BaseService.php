<?php

namespace app\Services;

use App\Enums\ServiceEnum;

class BaseService implements BaseServiceInterface {

	public function getServiceNameEnum(): ServiceEnum {
		return ServiceEnum::INSURANCE;
	}
}
