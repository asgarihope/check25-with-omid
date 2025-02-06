<?php

namespace Tests\Unit;


use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\InsuranceRequestHolderEnum;
use App\Services\Insurance\ThirdParties\OMID\OMID_ProviderInsuranceService;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class OMID_ProviderInsuranceServiceTest extends TestCase
{
    private OMID_ProviderInsuranceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new OMID_ProviderInsuranceService();
    }

    public function testMapRequest()
    {
        $dto = new InsuranceRequestDTO(
            InsuranceRequestHolderEnum::CONDUCTOR_PRINCIPAL,
            false,
            Carbon::now(),
            true,
            5,
            '2029-12-31'
        );

        $result =$this->callPrivateOrProtectedMethod($this->service,'mapRequest',[$dto]);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('company', $result);
        $this->assertArrayHasKey('data', $result);

        $this->assertTrue($result['company']['hasPrevInsurance']);
        $this->assertTrue($result['data']['holder']);
        $this->assertFalse($result['data']['hasSecondDriver']);
        $this->assertEquals(Carbon::now()->format('Y-m-d'), $result['data']['requestDate']);
        $this->assertEquals(5, $result['data']['prevInsuranceYears']);
        $this->assertEquals(0, $result['data']['numDrivers']);
    }


    public function testGenerateRequest()
    {
        $dto = new InsuranceRequestDTO(
            InsuranceRequestHolderEnum::CONDUCTOR_PRINCIPAL,
            false,
            Carbon::now(),
            true,
            5,
            '2023-12-31'
        );

        $result = $this->service->generateRequest($dto);

        $this->assertIsString($result);
        $this->assertJson($result);

        $decodedResult = json_decode($result, true);
        $this->assertIsArray($decodedResult);
        $this->assertArrayHasKey('company', $decodedResult);
        $this->assertArrayHasKey('data', $decodedResult);
    }
}
