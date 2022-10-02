<?php

namespace Modules\Finance\Tests\Feature;

use Modules\Base\Tests\AdminTestCase;
use Modules\Finance\Entities\Invoice;

class InvoiceTest extends AdminTestCase
{
    private static $invoiceUri = '/finance/invoice';

    //todo 发票列表接口测试
    public function testInvoiceList()
    {
        $param = [
            'limit' => 10,
            'page' => 1,
            'sort[created_at]' => 'desc',
            'filter[key]' => '',
            'filter[type]' => 1,
            'filter[company_uuid]' => null,
            'filter[assistant_uuid]' => null,
            'filter[cleared_status]' => null,
            'filter[to_void]' => null,
            'filter[created_at_begin]' => null,
            'filter[created_at_end]' => null,
            'filter[risk]' => null,
        ];
        $paramStr = http_build_query($param);
        return $this->getJson(self::$invoiceUri . '/invoices?'.$paramStr)
            ->assertSuccessful()
            ->assertJsonStructure(['data' => ['invoices']]);
    }

    //todo 发票详情接口测试
    public function testInvoiceDetail()
    {
        $invoice = Invoice::query()->first();
        if ($invoice) {
            return $this->getJson(self::$invoiceUri . '/invoices/' . $invoice->uuid . '/relate')
                ->assertSuccessful()
                ->assertJsonStructure(['data' => ['invoice', 'credit_notes']]);
        } else {
            $response = $this->get('/');
            $response->assertStatus(200);
        }
    }

    //todo 清账表下载接口测试
    public function testClearDownload()
    {
        $param = [
            'limit' => 10,
            'page' => 1,
            'sort[created_at]' => 'desc',
            'filter[key]' => 'IN',
            'filter[type]' => 1,
            'filter[company_uuid]' => 1,
            'filter[assistant_uuid]' => null,
            'filter[cleared_status]' => null,
            'filter[to_void]' => null,
            'filter[created_at_begin]' => '2020-03-25T10:47:07.000000Z',
            'filter[created_at_end]' => '2021-03-25T10:47:07.000000Z',
            'filter[risk]' => null,
            'deadline' => '2021-12-15T10:47:07.000000Z',
        ];
        $paramStr = http_build_query($param);
        return $this->getJson(self::$invoiceUri . '/invoices/clear/download?'.$paramStr,)
            ->assertSuccessful();
    }
}
