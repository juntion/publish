<?php

namespace Modules\Finance\Tests\Feature;

use Illuminate\Support\Str;
use Modules\Base\Tests\ApiTestCase;
use Modules\Finance\Entities\ClearAccounts;
use Modules\Finance\Entities\Invoice;
use Modules\Finance\Services\InvoiceService;

class InvoiceApiTest extends ApiTestCase
{
    private static $invoiceUri = '/finance/invoice';
    protected $inNumber = 'IN000000000001';

    //todo 创建发票接口测试
    public function testStoreInvoice()
    {
        $inNumber = $this->inNumber;
        $data = [
            'type' => $this->faker->randomElement([2,3]),
            'invoice_number' => 'IN041912090471',
            'origin_invoice_number' => '',
            'remark' => '测试',
        ];
        $this->partialMock(InvoiceService::class,  function ($mock) use($inNumber){
            $others['uuid'] = Str::uuid()->getHex()->toString();
            $others['amount'] = 0;
            $others['currency'] = '';
            $others['origin_uuid'] = '';
            $others['account_days'] = '';
            $others['assistant_name'] = $this->faker()->text(14);
            $others['assistant_uuid'] = Str::uuid()->getHex()->toString();
            $others['cleared'] = 0;
            $others['cleared_status'] = 0;
            $others['relate_id'] = $this->faker()->numberBetween(10000, 99999);
            $others['relate_type'] = 1;
            $others['to_void'] = 0;
            $others['number'] = $inNumber;
            $others['type'] = $this->faker->randomElement([2,3]);
            $others['remark'] = '测试用例';


            $customer['customer_number'] = $this->faker()->numberBetween(10000, 99999);
            $customer['customer_company_number'] = 'G751055019';
            $customer['customer_company_name'] = $this->faker()->text(14);
            $accountDays = $this->faker()->numberBetween(1, 100);
            $mock->shouldReceive('invoiceAdditionalInfo')
                ->once()
                ->andReturn($others);
            $mock->shouldReceive('invoiceCustomerInfo')
                ->once()
                ->andReturn($customer);
            $mock->shouldReceive('invoiceReceiptClear')
                ->once()
                ->andReturn(true);
            $mock->shouldReceive('getCurrenciesCode')
                ->once()
                ->andReturn('USD');
        });

        $response = $this->json('POST', self::$invoiceUri . '/api/invoices', $data);
        $response->assertSuccessful()->assertJsonStructure(['data' => ['invoice']]);
        $data = json_decode($response->content(), true);
        return $data['data']['invoice']['number'];
    }
    /**
     * 获取客户的未清账的发票 接口测试
     * @depends testStoreInvoice
     * @param $number
     * @throws \Exception
     */
    public function testCustomerUncleared($number)
    {
        $companyNumber = Invoice::query()->where('number', $number)->first();
        $data = [
            'customer_company_number' => $companyNumber->customer_company_number,
        ];
        $response = $this->json('post', self::$invoiceUri . '/api/customer/uncleared/invoices', $data);
        return $response->assertSuccessful()->assertJsonStructure(['data' => ['invoices']]);
    }

    /**
     * 发票作废接口测试
     * @depends testStoreInvoice
     * @param $number
     * @throws \Exception
     */
    public function testSoftInvoice($number)
    {
        $data = [
            'invoice_number' => $number,
            'admin_id' => 2916,
        ];
        $response = $this->json('delete', self::$invoiceUri . '/api/invoices/soft', $data);
        //Invoice::query()->withTrashed()->where('number', $number)->restore();
        return $response->assertSuccessful();
    }
    /**
     * 红冲接口测试
     * @depends testStoreInvoice
     * @param $number
     * @throws \Exception
     */
    public function testClearInvoice($number)
    {
        $data = [
            'action_type' => $this->faker->randomElement([2,3]),
            'income_number' => 'HZ123456',
            'income_currency' => 'USD',
            'income_clear' => $this->faker()->numberBetween(1, 100),
            'expend_number' => $number,
            'flag' => 1,
            'type' => 1,
            'remark' => 'api接口测试',
            'order_number' => 'FS123456',
            'admin_id' => '2916',
        ];
        $response = $this->json('patch', self::$invoiceUri . '/api/invoices/clear', $data);
        $response->assertSuccessful()->assertJsonStructure(['data' => ['invoice']]);
        $data = json_decode($response->content(), true);
        Invoice::query()->where('uuid', $data['data']['invoice']['uuid'])->forceDelete();
        ClearAccounts::query()->where('expend_number', $data['data']['invoice']['number'])->forceDelete();
        return $data;
    }
}
