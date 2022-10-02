<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyPayAccountInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_pay_account_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("pay_id")->comment("付款信息id");
            $table->foreign("pay_id")->references('id')->on('company_pay')->onDelete('cascade');
            $table->string("account_number")->comment("账号");
            $table->string("currency")->nullable()->comment("币种");
            $table->json("other_info")->nullable()->comment("其他账户信息");
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
        Schema::dropIfExists('company_pay_account_info');
    }
}
