<?php


namespace Modules\Base\Tests\Feature;


use Modules\Base\Entities\Company\Company;
use Modules\Base\Entities\Company\CompanyAddress;
use Modules\Base\Entities\Company\CompanyBank;
use Modules\Base\Tests\AdminTestCase;

class CompanyTest extends AdminTestCase
{
    private static $baseCompanyUrl = '/base/company/companies';

    protected $companyUuid;

    protected $officeAddressUuid;

    protected $warehouseAddressUuid;

    protected $regAddressUuid;

    public function testCompanies()
    {
         $this->getJson(self::$baseCompanyUrl. '?page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['companies']]);
    }

    public function testStoreCompany()
    {
        $response =  $this->postJson(self::$baseCompanyUrl,[
            'name' => $this->faker->name,
            'foreign_name' => $this->faker->name,
            'simple_name' => $this->faker->text(10),
            'type' => 1,
            'code' => $this->faker->text(5),
            'country_name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'time_zone'    => $this->faker->numberBetween(0, 12),
            'is_show'      => $this->faker->numberBetween(0, 1),
            'profile'      => $this->faker->text(32),
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['company']]);
        $data = json_decode($response->content(), true);
        $this->companyUuid = $data['data']['company']['uuid'];
        return $data['data']['company']['uuid'];
    }

    /**
     * @depends testStoreCompany
     */
    public function updateCompany($uuid)
    {
        return $this->patchJson(self::$baseCompanyUrl.'/'.$uuid,[
            'name' => $this->faker->name,
            'foreign_name' => $this->faker->name,
            'simple_name' => $this->faker->name,
            'type' => 1,
            'code' => substr($this->faker->name,0,4),
            'country_name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'time_zone'    => $this->faker->numberBetween(0, 12),
            'is_show'      => $this->faker->numberBetween(0, 1),
            'profile'      => $this->faker->text(32),
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['company']]);
    }

    /**
     * @depends testStoreCompany
     */
    public function testUpdateCompanyStatus($uuid)
    {
        return $this->patchJson(self::$baseCompanyUrl.'/'.$uuid.'/status', [
            'status' => 0,
            'comment' => $this->faker->text(12),
        ])->assertSuccessful();
    }

    /**
     * @depends testStoreCompany
     */
    public function testGetCompanyStatusLog($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/'.$uuid.'/statusLogs')->assertSuccessful()->assertJsonStructure(['data']);
    }

    public function testGetAllInfo()
    {
        return $this->getJson(self::$baseCompanyUrl.'/all/info?page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['companies']]);
    }

    /**
     * @depends testStoreCompany
     */
    public function testGetCompanyInfo($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/'.$uuid.'/info')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['companies']]);
    }

    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return mixed
     */
    public function testStoreRegistration($uuid)
    {
        $response =  $this->postJson(self::$baseCompanyUrl.'/'.$uuid.'/registration/addresses',[
            'name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'country_name' => $this->faker->name,
            'province'     => $this->faker->name,
            'city'         => $this->faker->name,
            'area'         => $this->faker->name,
            'address'      => $this->faker->name,
            'tel'          => $this->faker->text(12),
            'foreign_name' => $this->faker->name,
            'foreign_country_code' => substr($this->faker->name,0,2),
            'foreign_country_name' => $this->faker->name,
            'foreign_province'     => $this->faker->name,
            'foreign_city'         => $this->faker->name,
            'foreign_area'         => $this->faker->name,
            'foreign_address'      => $this->faker->name,
            'foreign_tel'          => $this->faker->text(12),
        ])->assertSuccessful()
            ->assertJsonStructure(['data' =>['company']]);
        $data = json_decode($response->content(), true);
        $this->regAddressUuid = $data['data']['company']['address']['uuid'];
        return $data['data']['company']['address']['uuid'];
    }

    /**
     * @depends testStoreRegistration
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateRegistration($uuid)
    {
        return $this->postJson(self::$baseCompanyUrl.'/registration/addresses/'.$uuid,[
            'name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'country_name' => $this->faker->name,
            'province'     => $this->faker->name,
            'city'         => $this->faker->name,
            'area'         => $this->faker->name,
            'address'      => $this->faker->name,
            'tel'          => $this->faker->text(12),
            'foreign_name' => $this->faker->name,
            'foreign_country_code' => substr($this->faker->name,0,2),
            'foreign_country_name' => $this->faker->name,
            'foreign_province'     => $this->faker->name,
            'foreign_city'         => $this->faker->name,
            'foreign_area'         => $this->faker->name,
            'foreign_address'      => $this->faker->name,
            'foreign_tel'          => $this->faker->text(12),
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['company']]);
    }

    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return mixed
     */
    public function testStoreOffice($uuid)
    {
        $response =  $this->postJson(self::$baseCompanyUrl.'/'.$uuid.'/office/addresses',[
            'name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'country_name' => $this->faker->name,
            'province'     => $this->faker->name,
            'city'         => $this->faker->name,
            'area'         => $this->faker->name,
            'address'      => $this->faker->name,
            'tel'          => $this->faker->text(12),
            'foreign_name' => $this->faker->name,
            'foreign_country_code' => substr($this->faker->name,0,2),
            'foreign_country_name' => $this->faker->name,
            'foreign_province'     => $this->faker->name,
            'foreign_city'         => $this->faker->name,
            'foreign_area'         => $this->faker->name,
            'foreign_address'      => $this->faker->name,
            'foreign_tel'          => $this->faker->text(12),
            'foreign_postcode'     => $this->faker->postcode,
            'postcode'     => $this->faker->postcode,
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['office']]);
        $data = json_decode($response->content(), true);
        $this->officeAddressUuid = $data['data']['office']['uuid'];
        return $data['data']['office']['uuid'];
    }

    /**
     * @depends testStoreOffice
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateOffice($uuid)
    {
        return $this->postJson(self::$baseCompanyUrl.'/office/addresses/'.$uuid,[
            'name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'country_name' => $this->faker->name,
            'province'     => $this->faker->name,
            'city'         => $this->faker->name,
            'area'         => $this->faker->name,
            'address'      => $this->faker->name,
            'tel'          => $this->faker->text(12),
            'foreign_name' => $this->faker->name,
            'foreign_country_code' => substr($this->faker->name,0,2),
            'foreign_country_name' => $this->faker->name,
            'foreign_province'     => $this->faker->name,
            'foreign_city'         => $this->faker->name,
            'foreign_area'         => $this->faker->name,
            'foreign_address'      => $this->faker->name,
            'foreign_tel'          => $this->faker->text(12),
            'foreign_postcode'     => $this->faker->postcode,
            'postcode'     => $this->faker->postcode,
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['office']]);
    }

    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testGetOffice($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/'.$uuid.'/office/addresses')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['offices']]);
    }

    /**
     * @depends  testStoreOffice
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateOfficeStatus($uuid)
    {
        return $this->patchJson(self::$baseCompanyUrl.'/office/addresses/'.$uuid.'/status', [
            'status' => 0,
            'comment' => $this->faker->text(12),
        ])->assertSuccessful();
    }

    /**
     * @depends testStoreOffice
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testGetOfficeStatusLog($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/office/addresses/'.$uuid.'/statusLogs')->assertSuccessful();
    }


    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return mixed
     */
    public function testStoreWarehouse($uuid)
    {
        $response =  $this->postJson(self::$baseCompanyUrl.'/'.$uuid.'/warehouse/addresses',[
            'name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'country_name' => $this->faker->name,
            'province'     => $this->faker->name,
            'city'         => $this->faker->name,
            'area'         => $this->faker->name,
            'address'      => $this->faker->name,
            'tel'          => $this->faker->text(12),
            'foreign_name' => $this->faker->name,
            'foreign_country_code' => substr($this->faker->name,0,2),
            'foreign_country_name' => $this->faker->name,
            'foreign_province'     => $this->faker->name,
            'foreign_city'         => $this->faker->name,
            'foreign_area'         => $this->faker->name,
            'foreign_address'      => $this->faker->name,
            'foreign_tel'          => $this->faker->text(12),
            'foreign_postcode'     => $this->faker->postcode,
            'postcode'     => $this->faker->postcode,
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['warehouse']]);
        $data = json_decode($response->content(), true);
        $this->warehouseAddressUuid = $data['data']['warehouse']['uuid'];
        return $data['data']['warehouse']['uuid'];
    }

    /**
     * @depends testStoreWarehouse
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateWarehouse($uuid)
    {
        return $this->postJson(self::$baseCompanyUrl.'/warehouse/addresses/'.$uuid,[
            'name' => $this->faker->name,
            'country_code' => substr($this->faker->name,0,2),
            'country_name' => $this->faker->name,
            'province'     => $this->faker->name,
            'city'         => $this->faker->name,
            'area'         => $this->faker->name,
            'address'      => $this->faker->name,
            'tel'          => $this->faker->text(12),
            'foreign_name' => $this->faker->name,
            'foreign_country_code' => substr($this->faker->name,0,2),
            'foreign_country_name' => $this->faker->name,
            'foreign_province'     => $this->faker->name,
            'foreign_city'         => $this->faker->name,
            'foreign_area'         => $this->faker->name,
            'foreign_address'      => $this->faker->name,
            'foreign_tel'          => $this->faker->text(12),
            'foreign_postcode'     => $this->faker->postcode,
            'postcode'     => $this->faker->postcode,
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['warehouse']]);
    }

    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testGetWarehouse($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/'.$uuid.'/warehouse/addresses')
            ->assertSuccessful()
            ->assertJsonStructure(['data' =>[ 'warehouses']]);
    }

    /**
     * @depends  testStoreWarehouse
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateWarehouseStatus($uuid)
    {
        return $this->patchJson(self::$baseCompanyUrl.'/warehouse/addresses/'.$uuid.'/status', [
            'status' => 0,
            'comment' => $this->faker->text(12),
        ])->assertSuccessful();
    }

    /**
     * @depends testStoreWarehouse
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testGetWarehouseStatusLog($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/warehouse/addresses/'.$uuid.'/statusLogs')->assertSuccessful();
    }


    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return mixed
     */
    public function testStoreBank($uuid)
    {
        $response = $this->postJson(self::$baseCompanyUrl.'/'.$uuid.'/bank', [
            'bank_name' => $this->faker->name,
            'account_name' => $this->faker->name,
            'account_info' => [
                [
                    'currency_code' => substr($this->faker->name,0,3),
                    'account_number' => $this->faker->numberBetween(10000,99999),
                    'payment_method_id' => $this->faker->numberBetween(1,99),
                    'payment_method_name' => $this->faker->name,
                ]
            ],
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['bank']]);
        $data = json_decode($response->content(), true);
        $uuid = $data['data']['bank']['uuid'];
        return $uuid;
    }

    /**
     * @depends testStoreBank
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateBank($uuid)
    {
        return $this->postJson(self::$baseCompanyUrl.'/bank/'.$uuid, [
            'bank_name' => $this->faker->name,
            'account_name' => $this->faker->name,
            'account_info' => [
                [
                    'currency_code' => substr($this->faker->name,0,3),
                    'account_number' => $this->faker->numberBetween(10000,99999),
                    'payment_method_id' => $this->faker->numberBetween(1,99),
                    'payment_method_name' => $this->faker->name,
                ]
            ],
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['bank']]);
    }

    /**
     * @depends testStoreBank
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testUpdateBankStatus($uuid)
    {
        return $this->patchJson(self::$baseCompanyUrl.'/bank/'.$uuid.'/status', [
            'status' => 0,
            'comment' => $this->faker->text(12),
        ])->assertSuccessful();
    }

    /**
     * @depends testStoreBank
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testGetBankStatusLog($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/bank/'.$uuid.'/statusLogs')->assertSuccessful();
    }

    /**
     * @depends testStoreCompany
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     */
    public function testGetBank($uuid)
    {
        return $this->getJson(self::$baseCompanyUrl.'/'.$uuid.'/bank')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['banks']]);
    }

    /**
     * @depends testStoreCompany
     * @depends testStoreRegistration
     * @depends testStoreOffice
     * @depends testStoreWarehouse
     * @depends testStoreBank
     * @param $uuid
     * @return \Illuminate\Testing\TestResponse
     * @throws \Exception
     */
    public function testGetTypeCompany($uuid, $uuid1, $uuid2, $uuid3, $uuid4)
    {
        $type = $this->faker->numberBetween(1,3);
        $company = Company::query()->find($uuid);
        $company->statusLogs()->delete();
        $company->taxInfo()->delete();
        $company->delete();
        $address = CompanyAddress::query()->find($uuid1);
        $address->statusLogs()->delete();
        $address->media()->delete();
        $address->delete();
        $office =  CompanyAddress::query()->find($uuid2);
        $office->statusLogs()->delete();
        $office->media()->delete();
        $office->allContacts()->delete();
        $office->delete();
        $warehouse = CompanyAddress::query()->find($uuid3);
        $warehouse->statusLogs()->delete();
        $warehouse->media()->delete();
        $warehouse->allContacts()->delete();
        $warehouse->delete();
        $bank = CompanyBank::query()->find($uuid4);
        $bank->bankAccount()->delete();
        $bank->statusLogs()->delete();
        $bank->media()->delete();
        $bank->delete();

        return $this->getJson(self::$baseCompanyUrl.'/all', ['type' => $type] )
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['companies']]);
    }


}
