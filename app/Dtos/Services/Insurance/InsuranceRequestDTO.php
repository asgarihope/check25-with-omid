<?php

namespace App\Dtos\Services\Insurance;

use App\Enums\InsuranceRequestHolderEnum;
use Carbon\Carbon;

class InsuranceRequestDTO {

	public function __construct(
		public InsuranceRequestHolderEnum $holder,// $condPpalEsTomador, // [boolean] Whether the holder is the main driver
		public bool                       $hasSecondDriver,// $conductorUnico, // [boolean] Whether there is more than one driver.
		public Carbon                     $requestDate,// $fecCot, // [string] Current date as ISO
		public bool                       $hasPrevInsurance,
		public int                        $prevInsuranceYears,// $anosSegAnte, // [number] Number of years in previous insurance as full years
		public ?string                    $prevInsuranceExpireDate,// bool $seguroEnVigor, // [boolean] If there is a previous insurance, and the previous insurance is still valid.
	) {
	}
}