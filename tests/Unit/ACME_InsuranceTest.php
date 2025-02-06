<?php

namespace Tests\Unit;

use App\Dtos\Services\Insurance\InsuranceRequestDTO;
use App\Enums\InsuranceProvidersEnum;
use App\Enums\InsuranceRequestHolderEnum;
use App\Enums\ServiceEnum;
use App\Exceptions\InsuranceException;
use App\Services\Insurance\ThirdParties\ACME\ACME_ProviderInsuranceService;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class ACME_InsuranceTest extends TestCase
{

    private ACME_ProviderInsuranceService $service;

    protected function setUp(): void
    {
        parent::setUp();
        $this->service = new ACME_ProviderInsuranceService();
    }

    public function testTransformBooleanValue()
    {
        $this->assertEquals('S', $this->callPrivateOrProtectedMethod($this->service, 'transformBooleanValue', [true]));
        $this->assertEquals('N', $this->callPrivateOrProtectedMethod($this->service, 'transformBooleanValue', [false]));
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

        $result = $this->service->mapRequest($dto);

        $this->assertIsArray($result);
        $this->assertArrayHasKey('Datos', $result);
        $this->assertArrayHasKey('DatosAseguradora', $result['Datos']);
        $this->assertArrayHasKey('DatosGenerales', $result['Datos']);

        $this->assertEquals('S', $result['Datos']['DatosAseguradora']['SeguroEnVigor']);
        $this->assertEquals('S', $result['Datos']['DatosGenerales']['CondPpalEsTomador']);
        $this->assertEquals('N', $result['Datos']['DatosGenerales']['ConductorUnico']);
        $this->assertEquals(5, $result['Datos']['DatosGenerales']['AnosSegAnte']);
        $this->assertEquals(0, $result['Datos']['DatosGenerales']['NroCondOca']);
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
        $this->assertStringContainsString('<TarificacionThirdPartyRequest>', $result);
        $this->assertStringContainsString('<Datos>', $result);
        $this->assertStringContainsString('<DatosAseguradora>', $result);
        $this->assertStringContainsString('<DatosGenerales>', $result);
    }
}
