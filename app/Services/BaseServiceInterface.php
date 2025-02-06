<?php

namespace app\Services;

use App\Enums\ServiceEnum;

interface BaseServiceInterface {

	public function getServiceNameEnum(): ServiceEnum;

}
