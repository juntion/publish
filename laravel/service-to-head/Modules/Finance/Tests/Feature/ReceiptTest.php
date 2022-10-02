<?php


namespace Modules\Finance\Tests\Feature;


use Carbon\Carbon;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Modules\Base\Contracts\Company\CompanyBankAccountsRepository;
use Modules\Base\Tests\AdminTestCase;
use Modules\ERP\Contracts\OrderCustomerCompanyService;
use Modules\ERP\Service\OrderService;
use Modules\ERP\Service\PaymentRelateOrdersService;
use Modules\Finance\Contracts\InvoiceService;
use Modules\Finance\Entities\PaymentReceipt;
use Modules\Finance\Entities\PaymentReceiptsLog;
use Modules\Finance\Entities\PaymentReceiptsToVoucher;
use Modules\Finance\Entities\PaymentReceiptsVouchersDetail;
use Modules\Finance\Entities\PaymentVoucher;
use Modules\Finance\Entities\PaymentVouchersLog;

class ReceiptTest extends AdminTestCase
{
    private static $baseUrl = '/finance/receipt/';
    private static $voucherBaseUrl = '/finance/voucher/';
    private static $customer = 461124883;


    public function testGetIndex()
    {
        $this->getJson(self::$baseUrl . 'receipts?page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['receipts']]);
    }

    public function testStore()
    {
        $this->mock(CompanyBankAccountsRepository::class,  function ($mock){
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
        $response = $this->postJson(self::$baseUrl . 'receipts', [
            'transaction_serial_number' => $this->faker()->text(12),
            'payment_method_id'         => 1,
            'currency'                  => "USD",
            'amount'                    => $this->faker()->numberBetween(100, 9999),
            'fee_fs'                    => $this->faker()->numberBetween(100,200),
            'payer_name'                => $this->faker()->name,
            'payer_email'               => $this->faker()->email,
            'customer_debit_account'    => $this->faker()->text(12),
            'payment_remark'            => $this->faker()->text(12),
            'payment_time'              => Carbon::now()
        ]);
        $data = json_decode($response->content(), true);
        return $data['data']['receipt']['uuid'];
    }

    /**
     *
     * @depends testStore
     * @param $uuid
     */
    public function testGetReceiptInfo($uuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $uuid)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['receipt']]);
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testGetVouchers($uuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $uuid . '/vouchers')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['vouchers']]);
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testGetFees($uuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $uuid . '/fees')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['fees']]);
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testGetFloats($uuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $uuid . '/floats')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['floats']]);
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testGetRefunds($uuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $uuid . '/refunds')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['refunds']]);
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testGetPrepays($uuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $uuid . '/prepays')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['prepays']]);
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testUpdate($uuid)
    {
        $this->mock(CompanyBankAccountsRepository::class,  function ($mock){
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
        $this->patchJson(self::$baseUrl.'receipts/'.$uuid, [
            'transaction_serial_number' => $this->faker()->text(12),
            'payment_method_id'         => 2,
            'currency'                  => "USD",
            'amount'                    => $this->faker()->numberBetween(100, 9999),
            'fee_fs'                    => $this->faker()->numberBetween(100, 200),
            'payer_name'                => $this->faker()->name,
            'payer_email'               => $this->faker()->email,
            'customer_debit_account'    => $this->faker()->text(12),
            'payment_remark'            => $this->faker()->text(12),
        ])->assertSuccessful()
            ->assertJsonStructure(['data' => ['receipt']]);

    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testDelete($uuid)
    {
        $this->deleteJson(self::$baseUrl . 'receipts/' . $uuid . '/soft')
            ->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testActive($uuid)
    {
        $this->postJson(self::$baseUrl . 'receipts/' . $uuid . '/active')
            ->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testStoreClaim($uuid)
    {
        $this->postJson(self::$baseUrl . 'applications/claim', [
            'receipt_uuid'    => $uuid,
            'customer_number' => self::$customer,
            'apply_remark'    => $this->faker()->text(12),
            'apply_file'      => [UploadedFile::fake()->image('test.jpg')],
        ])->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testVerifyClaim($uuid)
    {
        $receipt = PaymentReceipt::query()->find($uuid);

        $applicationsUuid = $receipt->application_uuid;
        $this->postJson(self::$baseUrl . 'applications/'.$applicationsUuid.'/verify', [
            'check_status' => 1,
            'check_remark' => $this->faker()->text(12),
        ])->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testStoreUnClaim($uuid)
    {
        $this->postJson(self::$baseUrl . 'applications/unclaim', [
            'receipt_uuid' => $uuid,
            'apply_remark' => $this->faker()->text(12),
        ])->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testDeleteClaim($uuid)
    {
        $receipt = PaymentReceipt::query()->find($uuid);
        $applicationsUuid = $receipt->application_uuid;
        $this->deleteJson(self::$baseUrl . 'applications/'.$applicationsUuid)->assertSuccessful();
    }

    /**
     * @depends testStore
     * @param $uuid
     */
    public function testSearch($uuid)
    {
        $receipt = PaymentReceipt::query()->find($uuid);
        $number = $receipt->number;
        $this->postJson(self::$baseUrl . 'receipts/search', [
            'number' => $number,
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['receipt']]);
    }

    public function testGetVoucherLists()
    {
        $this->getJson(self::$voucherBaseUrl . 'vouchers?page=1')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['vouchers']]);;
    }

    /**
     * @depends testStore
     */
    public function testStoreVoucher($uuid)
    {

        // mock 一些数据
        $this->mock(OrderCustomerCompanyService::class,  function ($mock){
            $customer = new Collection();
            $customer->customerNumber = self::$customer;

            // mock 客户
            $mock->shouldReceive('getCustomerAndCompanyInfoByOrderNumber')
                ->once()
                ->andReturn($customer);
        });

        $this->mock(OrderService::class, function ($mock){
            // mock 订单信息
            $returnData = new Collection();
            $returnData->order_number = "CW" . $this->faker->text(8);
            $returnData->order_currency = "USD";
            $returnData->order_price = "20";
            $returnData->split_order = 0;
            $returnData->product_height = 0;
            $returnData->origin_id = 0;
            $returnData->payment_method_id = 12;

            $returnData->products_instock_id = $this->faker->numberBetween(100000, 999999);
            $mock->shouldReceive('checkOrder')
                ->once()
                ->andReturn($returnData);
        });

        $this->mock(InvoiceService::class, function ($mock) {
           $mock->shouldReceive('invoiceReceiptClear')
               ->once()
               ->andReturn(true);
        });

        $this->mock(PaymentRelateOrdersService::class, function ($mock) {
            $res = new Collection();
            $res->id = false;
            $mock->shouldReceive('createByVoucher')
                ->once()
                ->andReturn($res);
        });

        $receipt = PaymentReceipt::query()->find($uuid);
        $response = $this->postJson(self::$voucherBaseUrl . 'vouchers', [
            'DK_info' => [
                [
                    'number'         => $receipt->number,
                    'exchange'       => 'false',
                    'currency'       => 'USD',
                    'order_currency' => "USD",
                    'use'            => 100,
                    'order_use'      => 100,
                ]
            ],
            'order_info' => [
                [
                    'order_number' => 'FS123123',
                    'currency'     => 'USD',
                    'order_price'  => 100,
                ]
            ],
            'remark'    => $this->faker->text(12)
        ])
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['vouchers']]);
        $data = json_decode($response->content(), true);
        return $data['data']['vouchers'][0]['uuid'];
    }


    /**
     * @depends testStore
     * @depends testStoreVoucher
     * @param $receiptUuid
     * @param $voucherUuid
     * @throws \Exception
     */
    public function testGetReceiptDetails($receiptUuid, $voucherUuid)
    {
        $this->getJson(self::$baseUrl . 'receipts/' . $receiptUuid . '/vouchers/' . $voucherUuid .'/details')
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['details']]);
        // 删除 创建的数据

        $receipt = PaymentReceipt::query()->find($receiptUuid);

        $voucher = PaymentVoucher::query()->find($voucherUuid);

        $receipt->claims->map(function ($v) {
            $v->media  ->map(function ($item){
                $item->delete();
            });
        });

        $receipt->claims()->delete();

        $voucher->media->map(function ($item){
            $item->delete();
        });

        PaymentReceiptsToVoucher::query()->where('receipt_uuid', $receiptUuid)->delete();

        PaymentReceiptsVouchersDetail::query()->where('receipt_uuid', $receiptUuid)->delete();

        PaymentVouchersLog::query()->where('uuid', $voucherUuid)->delete();

        PaymentReceiptsLog::query()->where('uuid', $receiptUuid)->delete();

        $receipt->forceDelete();
        $voucher->forceDelete();
    }
}
