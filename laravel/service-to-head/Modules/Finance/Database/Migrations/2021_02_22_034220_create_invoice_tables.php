<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 发票管理
 *
 * Class CreateInvoiceTables
 */
class CreateInvoiceTables extends Migration
{
    public function up()
    {
        $prefix = config('finance.prefix');

        /**
         * 发票表
         */
        Schema::create($prefix . 'invoices', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('origin_uuid',32)->nullable()->comment('原始发票uuid(重开发票对应的原发票id)');
            $table->char('number', 16)->comment('发票编号，IN开头');
            $table->tinyInteger('type')->default(0)->comment('出账单据的类型，1：货物发票,2：服务发票,3：其他补款发票');

            $table->char('company_uuid', 32)->nullable()->comment('发货主体，公司主体 对应companies.uuid');
            $table->string('company_name')->nullable()->comment('发货主体公司名称 对应companies.name');
            $table->char('customer_company_number',16)->nullable()->comment('客户的公司编码');
            $table->string('customer_company_name')->nullable()->comment('客户的公司名称');
            $table->char('customer_number',16)->nullable()->comment('客户编号');

            $table->char('currency', 3)->comment('币种 例:USD');
            $table->unsignedInteger('amount')->comment('发票总额，需清账总额，单位：分');
            $table->unsignedInteger('cleared')->comment('已清总额，cleared <=> amount (未清余额 = amount - cleared)，单位：分');
            $table->unsignedInteger('account_days')->default(0)->comment('账期天数，0 表示没有');
            $table->string('assistant_name')->comment('发票承运人 admins.name');
            $table->char('assistant_uuid', 32)->comment('发票承运人id admins.uuid');
            $table->tinyInteger('to_void')->default(0)->comment('是否作废 0 正常 1作废 2 重开');
            $table->tinyInteger('cleared_status')->default(0)->comment('核销状态 0 未核销 1 部分核销 2 已核销');

            $table->text('remark')->nullable()->default(null)->comment('发票备注');

            $table->unsignedInteger('relate_id')->comment('发票关联实际订单id');
            $table->tinyInteger('relate_type')->default(1)->comment('1为CW单，2为HF单');

            $table->softDeletes();
            $table->timestamps();

            $table->index('origin_uuid');
            $table->unique('number');
            $table->index('company_uuid');
            $table->index('customer_company_number');
            $table->index('customer_number');
            $table->index('assistant_uuid');
            $table->index('relate_id');
            $table->index('created_at');
        });

        /**
         * 发票对应的到款表，发票核销到款表
         */
        Schema::create($prefix . 'invoices_to_receipts', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32)->primary();
            $table->char('invoice_uuid', 32);
            $table->char('invoice_number', 16)->comment('发票编号，IN开头，'.$prefix.'invoices.number');
            $table->char('invoice_currency', 3)->comment('发票币种,例如：USD,CNY，'.$prefix.'invoices.currency');
            $table->unsignedInteger('invoice_clear')->comment('发票币种的发票核销金额，单位：分');

            $table->char('voucher_number', 32)->comment('用款编号，CW开头，兼容原erp历史数据扩充至32'.$prefix.'payment_vouchers.number');
            $table->char('voucher_currency', 3)->comment('用款币种,例如：USD,CNY，'.$prefix.'payment_vouchers.currency');
            $table->unsignedInteger('voucher_clear')->comment('用款币种的用款核销金额，单位：分');

            $table->char('receipt_uuid', 32);
            $table->char('receipt_number', 16)->comment('到款编号，DK开头，'.$prefix.'payment_receipts.number');
            $table->char('receipt_currency', 3)->comment('到款币种,例如：USD,CNY，'.$prefix.'payment_receipts.currency');
            $table->unsignedInteger('receipt_clear')->comment('到款币种的到款核销金额，单位：分');

            $table->unsignedInteger('order_id')->comment('订单id,对应原erp的 products_instock_shipping.products_instock_id');
            $table->char('order_number',32)->comment('订单编号,发票对应的订单CW编号,对应原erp products_instock_shipping.orders_num');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index('invoice_number');
            $table->index('voucher_number');
            $table->index('receipt_number');
            $table->index('order_id');
            $table->index('order_number');

            $table->foreign('invoice_uuid')->references('uuid')->on($prefix . 'invoices');
            $table->foreign('receipt_uuid')->references('uuid')->on($prefix . 'payment_receipts');
        });
    }

    public function down()
    {
        $prefix = config('finance.prefix');

        Schema::dropIfExists($prefix . 'invoices_to_receipts');
        Schema::dropIfExists($prefix . 'invoices');
    }
}
