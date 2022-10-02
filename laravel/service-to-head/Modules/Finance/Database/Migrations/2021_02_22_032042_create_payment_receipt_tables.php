<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

/**
 * 到款凭证管理，客户的钱是怎么来的
 *
 * Class CreatePaymentReceiptTables
 */
class CreatePaymentReceiptTables extends Migration
{
    public function up()
    {
        $prefix = config('finance.prefix');// 财务系统数据表前缀

        /**
         * 到款凭证表，相当于原erp的到款 DK 的信息
         */
        Schema::create($prefix . 'payment_receipts', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('number', 16)->comment('到款编号，DK开头，对应原erp的ns_push_payment.orders_num');
            $table->string('transaction_serial_number')->nullable()->comment('银行交易流水号,对应原erp的ns_push_payment.bankser_num');
            $table->boolean('is_match')->default(false)->comment('是否匹配，false：不匹配，true：匹配，财务上传的表格里是否匹配到这条记录');

            $table->char('currency', 3)->comment('到款币种,例如：USD,CNY');
            $table->unsignedInteger('amount')->comment('到款总额，财务录入的钱，并不是可用金额，单位：分');
            $table->unsignedInteger('fee_fs')->default(0)->comment('宇轩收款银行到宇轩公司收取的手续费，银行收公司的手续费（财务录的），单位:分,ns_push_payment.bank_commission');
            $table->unsignedInteger('fee')->default(0)->comment('总手续费，银行收公司的手续费（财务录的）+ 银行收客户的手续费（销售申请的），单位：分');
            $table->integer('float')->default(0)->comment('币种转换差额，汇率浮动值，可正可负，单位：分');
            $table->unsignedInteger('usable')->comment('可用总额，usable = amount + fee + float, usable > 0 单位：分');
            $table->unsignedInteger('used')->comment('已用总额，used <= usable (剩余可用 = usable - used)，单位：分');

            $table->unsignedInteger('cleared')->comment('已清账金额，单位：分');

            $table->char('company_uuid', 32)->nullable()->comment('到款主体，公司主体 对应companies.uuid');
            $table->string('company_name')->nullable()->comment('到款主体公司名称 对应companies.name');
            $table->string('company_account_number')->nullable()->comment('宇轩对应收款账号,ns_push_payment.fs_shroff_account_number, company_bank_accounts.account_number');
            $table->char('customer_company_number',16)->nullable()->comment('客户的公司编码');
            $table->string('customer_company_name')->nullable()->comment('客户的公司名称');
            $table->char('customer_number',16)->nullable()->comment('客户编号');
            $table->string('customer_debit_account')->nullable()->comment('客户打款账号,ns_push_payment.customer_debit_account');

            $table->string('payer_name')->nullable()->comment('付款人名称');
            $table->string('payer_email')->nullable()->comment('付款人邮箱');
            $table->integer('payment_method_id')->comment('客户付款方式id,兼容旧数据 对应原erp的payment_method.id');
            $table->string('payment_method_name')->comment('客户付款方式名称 对应原erp的payment_method.payment_method');
            $table->text('payment_remark')->nullable()->default(null)->comment('到款备注，客户打款备注 对应原erp的ns_push_payment.remark');
            $table->timestamp('payment_time')->nullable()->comment('银行到款日期,存储的时候需注意转换对应时区 对应原erp的ns_push_payment.date');

            $table->char('order_number',32)->nullable()->default(null)->comment('FS订单编号');

            $table->char('claim_uuid', 32)->nullable()->comment('认领人,admins.uuid');
            $table->string('claim_name')->nullable()->comment('认领人名,admins.name');
            $table->tinyInteger('claim_status')->default(0)->comment('认领状态  0 默认未认领 1审核中（提交到款认领申请中，取消认领申请中），2已认领');
            $table->tinyInteger('claim_type')->default(0)->comment('认领类型 0 手动认领 1 自动认领');
            $table->timestamp('claim_time')->nullable()->comment('认领时间');

            $table->char('application_uuid', 32)->nullable()->comment('当前认领申请审核流程的uuid,payment_claim_applications.uuid');

            $table->tinyInteger('create_from')->default(0)->comment('到款来源  0 手动新增 1 表格导入 2 自动导入 3 客户垫付');
            $table->char('creator_uuid', 32)->comment('创建人,admins.uuid');
            $table->string('creator_name')->comment('创建人名,admins.name');

            $table->softDeletes();
            $table->timestamps();

            $table->unique('number');
            $table->unique('transaction_serial_number');
            $table->index('company_uuid');
            $table->index('customer_company_number');
            $table->index('customer_number');
            $table->index('payment_method_id');
            $table->index('order_number');
            $table->index('claim_uuid');
            $table->unique('application_uuid');
            $table->index('claim_time');
            $table->index('created_at');
        });

        /**
         * 到款凭证认领/撤销认领审核
         */
        Schema::create($prefix . 'payment_claim_applications', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32)->primary();
            $table->char('receipt_uuid', 32)->comment('到款id '.$prefix .'payment_receipts.uuid');
            $table->char('customer_company_number',16)->nullable()->comment('客户的公司编码');
            $table->char('customer_number',16)->nullable()->comment('客户编号');

            $table->char('apply_uuid', 32)->comment('申请人id admins.uuid');
            $table->string('apply_name')->comment('申请人名称 admins.name');
            $table->tinyInteger('apply_type')->comment('申请类型 1,认领 2,取消认领');
            $table->text('apply_remark')->nullable()->default(null)->comment('申请备注');

            $table->char('check_uuid', 32)->nullable()->comment('审核人id admins.uuid');
            $table->string('check_name')->nullable()->comment('审核人名称 admins.name');
            $table->tinyInteger('check_status')->default(0)->comment('审核状态 0 待审核 1 审核通过 2 审核驳回');
            $table->text('check_remark')->nullable()->default(null)->comment('审核备注');
            $table->timestamp('check_time')->nullable()->comment('审核时间');

            $table->timestamps();

            $table->foreign('receipt_uuid')->references('uuid')->on($prefix . 'payment_receipts');
        });

        /**
         * 到款凭证认领/撤销认领审核文件
         */
        Schema::create($prefix . 'payment_claim_apply_files', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32)->primary();
            $table->char('apply_uuid', 32)->comment('申请的uuid '.$prefix .'payment_claim_applications.uuid');
            $table->string('name')->comment('文件名');
            $table->string('storage_name')->comment('文件重命名');
            $table->string('path')->comment('文件路径');
            $table->tinyInteger('type')->comment('文件类型 1.申请审核的附件（销售附件） 2.审核附件（财务附件）');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('apply_uuid')->references('uuid')->on($prefix . 'payment_claim_applications');
        });

        /**
         * 到款凭证日志表
         */
        Schema::create($prefix . 'payment_receipts_logs', function (Blueprint $table) use ($prefix) {
            $table->char('uuid', 32);
            $table->json('log')->comment('日志，json格式，必有字段：待补充，自定义字段：待补充');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('uuid')->references('uuid')->on($prefix . 'payment_receipts')->cascadeOnUpdate()->cascadeOnDelete();
        });
    }

    public function down()
    {
        $prefix = config('finance.prefix');// 财务系统数据表前缀

        Schema::dropIfExists($prefix . 'payment_receipts_logs');
        Schema::dropIfExists($prefix . 'payment_claim_apply_files');
        Schema::dropIfExists($prefix . 'payment_claim_applications');
        Schema::dropIfExists($prefix . 'payment_receipts');
    }
}
