<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPay extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_pay', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("company_id")->comment("公司id");
            $table->foreign("company_id")->references('id')->on('companies')->onDelete('cascade');
            $table->string("pay_method")->comment("付款方式");
            $table->unsignedTinyInteger("status")->default(1)->comment("状态 1使用中 0已注销");
            $table->text("comment")->nullable()->comment("简介说明");
            $table->string("bank_name")->comment("银行名称");
            $table->string("account_name")->comment("收款人/账户名");
            $table->json("other_info")->nullable()->comment("银行的其他信息");
            $table->string("check_address")->nullable()->comment("支票接收地址");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('company_pay');
    }
}
