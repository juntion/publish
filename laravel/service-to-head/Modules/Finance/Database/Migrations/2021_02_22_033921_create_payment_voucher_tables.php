<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 支出凭证管理，客户的钱是怎么用的
 *
 * Class CreatePaymentVoucherTables
 */
class CreatePaymentVoucherTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $prefix = config('finance.prefix');// 财务系统数据表前缀

        /**
         * 用款凭证表，相当于原erp的到款 CW 的信息
         */
        Schema::create($prefix . 'payment_vouchers', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('number', 32)->comment('用款编号，CW开头，兼容原erp历史数据扩充至32,对应原erp的ns_expense_voucher_record.ns_vouch_num');

            $table->char('currency', 3)->comment('支出币种,例如：USD,CNY');
            $table->unsignedInteger('usable')->comment('用款凭证总额，可用总额,单位：分');
            $table->unsignedInteger('used')->comment('已用总额，used <= usable (剩余可用 = usable - used)，单位：分');

            $table->tinyInteger('type')->comment('支出类型 1 真实到款 2 账期额度 3 临时额度 4 部分额度(存款优先)，对应原erp的ns_expense_voucher_record.fs_vouch_type');

            $table->char('customer_company_number',16)->nullable()->comment('客户的公司编码');
            $table->string('customer_company_name')->nullable()->comment('客户的公司名称');
            $table->char('customer_number',16)->nullable()->comment('客户编号');
            $table->char('order_number',32)->nullable()->comment('FS订单编号，对应原erp的ns_expense_voucher_record.fs_so_num');
            $table->text('remark')->nullable()->default(null)->comment('支出备注,对应原erp的ns_expense_voucher_record.fs_remarks');

            $table->char('creator_uuid', 32)->nullable()->comment('创建人,admins.uuid');
            $table->string('creator_name')->nullable()->comment('创建人名,admins.name');
            $table->softDeletes();
            $table->timestamps();

            $table->integer('ns_vouch_id')->nullable()->default(null)->comment('原凭证对应的ns_id,兼容旧数据,对应原erp的ns_expense_voucher_record.ns_vouch_id')->unique();

            $table->unique('number');
            $table->index('creator_uuid');
            $table->index('created_at');
        });

        /**
         * 用款凭证日志表
         */
        Schema::create($prefix . 'payment_vouchers_logs', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32);
            $table->json('log')->comment('日志，json格式，必有字段：待补充，自定义字段：待补充');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('uuid')->references('uuid')->on($prefix . 'payment_vouchers')->cascadeOnUpdate()->cascadeOnDelete();
        });

        /**
         * 用款凭证文件表,记录支出时销售上传的文件
         */
        Schema::create($prefix . 'payment_vouchers_files', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32)->primary();
            $table->char('vouch_uuid', 32)->comment('凭证id '.$prefix .'payment_vouchers.uuid');
            $table->string('name')->comment('文件名');
            $table->string('storage_name')->comment('文件重命名');
            $table->string('path')->comment('文件路径');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('vouch_uuid')->references('uuid')->on($prefix . 'payment_vouchers');
        });

        /**
         * 到款凭证和用款凭证的关系表
         */
        Schema::create($prefix . 'payment_receipts_to_vouchers', function (Blueprint $table) use ($prefix) {
            $table->char('receipt_uuid', 32);
            $table->char('receipt_number', 16)->comment('到款编号，DK开头，'.$prefix.'payment_receipts.number');
            $table->char('receipt_currency', 3)->comment('到款币种,例如：USD,CNY，'.$prefix.'payment_receipts.currency');
            $table->unsignedInteger('receipt_init')->comment('到款币种的到款拆分金额，初始使用金额，单位：分');
            $table->unsignedInteger('receipt_use')->comment('到款币种的到款拆分金额，实际使用金额，单位：分');

            $table->char('voucher_uuid', 32);
            $table->char('voucher_number', 32)->comment('用款编号，CW开头，兼容原erp历史数据扩充至32 '.$prefix.'payment_vouchers.number');
            $table->char('voucher_currency', 3)->comment('用款币种,例如：USD,CNY，'.$prefix.'payment_vouchers.currency');
            $table->unsignedInteger('voucher_init')->comment('用款币种的用款拆分金额，初始使用金额，单位：分');
            $table->unsignedInteger('voucher_use')->comment('用款币种的用款拆分金额，实际使用金额，单位：分');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['receipt_uuid', 'voucher_uuid']);
            $table->index('receipt_number');
            $table->index('voucher_number');

            $table->foreign('receipt_uuid')->references('uuid')->on($prefix . 'payment_receipts');
            $table->foreign('voucher_uuid')->references('uuid')->on($prefix . 'payment_vouchers');
        });

        /**
         * 到款凭证的拆分明细表,
         * 用款凭证的拆分明细表,
         *
         * 到款 和 用款 拆分的最小粒度
         */
        Schema::create($prefix . 'payment_receipts_vouchers_details', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32)->primary();

            $table->char('receipt_uuid', 32);
            $table->char('receipt_number', 16)->comment('到款编号，DK开头，'.$prefix.'payment_receipts.number');
            $table->char('receipt_currency', 3)->comment('到款币种,例如：USD,CNY，'.$prefix.'payment_receipts.currency');
            $table->unsignedInteger('receipt_use')->comment('到款币种的到款拆分金额，单位：分');

            $table->char('voucher_uuid', 32);
            $table->char('voucher_number', 32)->comment('用款编号，CW开头，兼容原erp历史数据扩充至32 '.$prefix.'payment_vouchers.number');
            $table->char('voucher_currency', 3)->comment('用款币种,例如：USD,CNY，'.$prefix.'payment_vouchers.currency');
            $table->unsignedInteger('voucher_use')->comment('用款币种的用款拆分金额，单位：分');

            $table->string('order_number')->nullable()->comment('订单编号,cw开头,对应原erp orders_of_dk_data_details.orders_num');
            $table->unsignedInteger('order_id')->comment('订单id,对应原erp orders_of_dk_data_details.products_instock_id');
            $table->unsignedInteger('parent_id')->nullable()->comment('父级订单id,对应原erp products_instock_shipping.products_instock_id');
            $table->unsignedInteger('origin_id')->nullable()->comment('原始订单id,即支出凭证对应的订单id,对应原erp products_instock_shipping.products_instock_id');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index('receipt_number');
            $table->index('voucher_number');
            $table->index('order_number');
            $table->index('order_id');
            $table->index('parent_id');
            $table->index('origin_id');

            $table->foreign('receipt_uuid')->references('uuid')->on($prefix . 'payment_receipts');
            $table->foreign('voucher_uuid')->references('uuid')->on($prefix . 'payment_vouchers');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $prefix = config('finance.prefix');// 财务系统数据表前缀

        Schema::dropIfExists($prefix . 'payment_receipts_vouchers_details');
        Schema::dropIfExists($prefix . 'payment_receipts_to_vouchers');
        Schema::dropIfExists($prefix . 'payment_vouchers_files');
        Schema::dropIfExists($prefix . 'payment_vouchers_logs');
        Schema::dropIfExists($prefix . 'payment_vouchers');
    }
}
