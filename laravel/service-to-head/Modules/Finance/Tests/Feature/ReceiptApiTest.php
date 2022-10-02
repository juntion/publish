<?php


namespace Modules\Finance\Tests\Feature;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\Base\Tests\ApiTestCase;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentVoucher;
use Modules\Finance\Http\Controllers\Controller;
use Modules\Finance\Http\Controllers\Receipt\ReceiptController;
use Modules\Finance\Http\Controllers\Voucher\VoucherController;

class ReceiptApiTest extends ApiTestCase
{
    protected $adminId = 2916;

    protected static $baseUrl = '/finance/receipt/api/receipts';
    protected static $voucherBaseUrl = '/finance/voucher/api/vouchers';

    public function testApiStore()
    {
        $this->mock(CompanyBankAccountsRepository::class, function ($mock) {
            $data = new Collection();
            $company = new Collection();
            $company->uuid = Str::uuid()->getHex()->toString();
            $company->name = $this->faker->name;
            $data->company = $company;
            $data->account_number = $this->faker->text(12);
            $mock->shouldReceive('getAccountAndCompanyInfoByMethodAndCurrency')
                ->once()
                ->andReturn($data);
        });

        $this->partialMock(ReceiptController::class, function ($mock){
            $mock->shouldAllowMockingProtectedMethods()->shouldReceive('checkPermission')->once()->andReturn(true);
        });

        $response = $this->postJson(self::$baseUrl, [
            'transaction_serial_number' => $this->faker()->text(12),
            'payment_method_id'         => 1,
            'currency'                  => "USD",
            'amount'                    => $this->faker()->numberBetween(100, 9999),
            'fee_fs'                    => $this->faker()->numberBetween(100, 200),
            'payer_name'                => $this->faker()->name,
            'payer_email'               => $this->faker()->email,
            'customer_debit_account'    => $this->faker()->text(12),
            'payment_remark'            => $this->faker()->text(12),
            'admin_id'                  => $this->adminId,
            'apply_id'                  => $this->adminId,
            'customer_number'           => 461124883,
        ])->assertSuccessful();
        $data = json_decode($response->content(), true);
        return $data['data']['receipt']['number'];
    }

    /**
     * @depends testApiStore
     */
    public function testApiSearch($number)
    {
        $this->partialMock(ReceiptController::class, function ($mock){
            $mock->shouldAllowMockingProtectedMethods()->shouldReceive('checkPermission')->once()->andReturn(true);
        });
        $this->postJson(self::$baseUrl.'/search', [
            'number'   => $number,
            'admin_id' => $this->adminId
        ])->assertSuccessful()->assertJsonStructure(['data' => ['receipts']]);
    }

    /**
     * @depends testApiStore
     */
    public function testApiUse($number)
    {
        $this->postJson(self::$baseUrl.'/use', [
            'number'   => $number,
            'currency' => 'USD',
            'use'      => $this->faker->numberBetween(1, 99),
            'admin_id' => $this->adminId
        ])->assertSuccessful();
    }

    /**
     * @depends testApiStore
     */
    public function testApiFee($number)
    {
        $this->partialMock(ReceiptController::class, function ($mock){
            $mock->shouldAllowMockingProtectedMethods()->shouldReceive('checkPermission')->once()->andReturn(true);
        });
        $this->postJson(self::$baseUrl.'/fee', [
            'number'   => $number,
            'currency' => 'USD',
            'fee'      => $this->faker->numberBetween(1, 99),
            'admin_id' => $this->adminId
        ])->assertSuccessful();
    }

    /**
     * @depends testApiStore
     */
    public function testApiFloat($number)
    {
        $this->partialMock(ReceiptController::class, function ($mock){
            $mock->shouldAllowMockingProtectedMethods()->shouldReceive('checkPermission')->once()->andReturn(true);
        });
        $this->postJson(self::$baseUrl.'/float', [
            'number'   => $number,
            'currency' => 'USD',
            'float'    => $this->faker->numberBetween(1, 99),
            'admin_id' => $this->adminId
        ])->assertSuccessful();
    }

    /**
     * @depends testApiStore
     */
    public function testApiSoft($number)
    {
        $this->partialMock(ReceiptController::class, function ($mock){
            $mock->shouldAllowMockingProtectedMethods()->shouldReceive('checkPermission')->once()->andReturn(true);
        });
        $receipt = PaymentReceipt::query()->where('number', $number)->first();
        $receipt->update([
            'used' => 0,
        ]);
        $receipt->claims()->delete();
        $receipt->logs()->delete();

        $this->deleteJson(self::$baseUrl.'/soft', [
            'number'   => $number,
            'admin_id' => $this->adminId
        ])->assertSuccessful();
        PaymentReceipt::query()->where('number', $number)->forceDelete();
    }


    public function testApiVoucherStore()
    {
        $this->partialMock(VoucherController::class, function ($mock){
            $mock->shouldAllowMockingProtectedMethods()->shouldReceive('checkPermission')->once()->andReturn(true);
        });
        $response = $this->postJson(self::$voucherBaseUrl, [
            'order_number'            => $this->faker->text(12),
            'currency'                => "USD",
            'order_price'             => $this->faker->numberBetween(1000, 9999),
            'type'                    => $this->faker->randomElement([2, 3, 4]),
            'remark'                  => $this->faker->text(12),
            'customer_company_number' => $this->faker->text(12),
            'customer_company_name'   => $this->faker->text(12),
            'customer_number'         => $this->faker->text(12),
            'admin_id'                => $this->adminId,
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['voucher']]);

        $data = json_decode($response->content(), true);
        $uuid = $data['data']['voucher']['uuid'];
        PaymentVoucher::query()->find($uuid)->forceDelete();
    }
}
