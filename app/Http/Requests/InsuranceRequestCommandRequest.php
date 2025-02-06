<?php

namespace App\Http\Requests;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\BooleanInputValuesEnum;
use App\Enums\InsuranceRequestHolderEnum;
use Carbon\Carbon;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;

class InsuranceRequestCommandRequest extends FormRequest {

	public function authorize(): bool {
		return true;
	}

	public function rules(): array {
		return [
			'holder'                       => ['required', new Enum(InsuranceRequestHolderEnum::class)],
			'occasionalDriver'             => ['required', new Enum(BooleanInputValuesEnum::class)],
			'prevInsurance_exists'         => ['required',new Enum(BooleanInputValuesEnum::class)],
			'prevInsurance_years'          => ['required', 'int'],
			'prevInsurance_expirationDate' => [
				'nullable',
				'date',
				'date_format:Y-m-d',
			],
		];
	}

	public function toDTO(): InsuranceRequestDTO {
		return new InsuranceRequestDTO(
			InsuranceRequestHolderEnum::from($this->holder),
			$this->occasionalDriver === BooleanInputValuesEnum::SI->value,//	$this->occasionalDriver,
			Carbon::now(),
			$this->prevInsurance_exists,
			$this->prevInsurance_years,
			$this->prevInsurance_expirationDate
		);
	}
}
