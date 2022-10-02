<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateClearAccountTables extends Migration
{
    public function up()
    {
        $prefix = config('finance.prefix');

        /**
         * 清账表，清账流水表，发票的核清流水表
         */
        Schema::create($prefix . 'clear_accounts', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();

            $table->char('income_number', 16)->comment('入账编号，例如：DK,CN,HZ,....');
            $table->char('income_currency', 3)->comment('入账币种,例如：USD,CNY');
            $table->unsignedInteger('income_clear')->comment('入账单据的清账金额，单位：分');

            $table->char('expend_number', 16)->comment('出账编号，例如：IN');
            $table->char('expend_currency', 3)->comment('出账币种,例如：USD,CNY');
            $table->unsignedInteger('expend_clear')->comment('出账单据的清账金额，单位：分');
            $table->integer('expend_unclear')->comment('出账单据的未清余额,的，单位：分');
            $table->boolean('expend_status')->comment('出账单据的状态，true：有效，false：无效，作废');

            $table->boolean('flag')->comment('清账标志 true 正向清账:减未清余额 false 反向清账:加未清余额');
            $table->tinyInteger('type')->comment('清账类型，1：银行回款，2：现金折扣，3：发票作废，4：坏账申请，5：取消补款，6：商业折让，7：退货退款，8：退货不退款，9：退款不退货');
            $table->text('remark')->nullable()->default(null)->comment('清账备注');
            $table->char('order_number',32)->nullable()->comment('FS订单编号，清账的订单');

            $table->char('clear_uuid', 32)->comment('流水操作人 admins.uuid');
            $table->char('clear_name', 32)->comment('流水操作人名 admins.name');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index('income_number');
            $table->index('expend_number');
            $table->index('order_number');
        });
    }

    public function down()
    {
        $prefix = config('finance.prefix');

        Schema::dropIfExists($prefix . 'clear_accounts');
    }
}
