<?php

namespace Tests\Unit\Console\Commands;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Http\Requests\InsuranceRequestCommandRequest;
use app\Services\Insurance\InsuranceServiceInterface;
use Illuminate\Support\Facades\File;
use Mockery;
use Tests\TestCase;

class InsuranceRequestCommandTest extends TestCase
{

    public function test_handle_request_success()
    {
        $mockService = Mockery::mock(InsuranceServiceInterface::class);
        $mockService->shouldReceive('handleRequest')
            ->once()
            ->andReturn('Processed Insurance Request');

        $this->app->instance(InsuranceServiceInterface::class, $mockService);


        $sampleData = json_encode([
            'holder' => 'CONDUCTOR_PRINCIPAL',
            'occasionalDriver' => 'SI',
            'prevInsurance_exists' => 'SI',
            'prevInsurance_years' => 5,
            'prevInsurance_expirationDate' => '2025-12-31',
        ]);
        $filePath = storage_path('app/private/sample_request.json');
        File::put($filePath, $sampleData);


        $this->artisan('insurance', ['--file' => 'sample_request.json'])
            ->expectsOutput('Processed Insurance Request')
            ->assertExitCode(0);

        File::delete($filePath);

    }

    public function test_request_validation_fails()
    {
        $request = new InsuranceRequestCommandRequest([
            'holder' => 'INVALID_HOLDER',
            'occasionalDriver' => 'YES',
            'prevInsurance_years' => 'two',
            'prevInsurance_expirationDate' => 'invalid-date'
        ]);

        $validator = validator($request->all(), $request->rules());
        $this->assertTrue($validator->fails());
        $this->assertArrayHasKey('holder', $validator->errors()->toArray());
        $this->assertArrayHasKey('prevInsurance_years', $validator->errors()->toArray());
        $this->assertArrayHasKey('prevInsurance_expirationDate', $validator->errors()->toArray());
    }

    public function test_dto_conversion_success()
    {
        $request = new InsuranceRequestCommandRequest([
            'holder' => 'CONDUCTOR_PRINCIPAL',
            'occasionalDriver' => 'SI',
            'prevInsurance_years' => 2,
            'prevInsurance_exists' => 'SI',
            'prevInsurance_expirationDate' => '2025-12-31'
        ]);

        $dto = $request->toDTO();

        $this->assertInstanceOf(InsuranceRequestDTO::class, $dto);
        $this->assertEquals('CONDUCTOR_PRINCIPAL', $dto->holder->value);
        $this->assertTrue($dto->hasSecondDriver);
        $this->assertEquals(2, $dto->prevInsuranceYears);
        $this->assertEquals('2025-12-31', $dto->prevInsuranceExpireDate);
    }

}
