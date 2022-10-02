<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyTaxInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_tax_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("company_id")->comment("公司id");
            $table->foreign('company_id')->references('id')->on('companies')->onDelete('cascade');
            $table->string("country")->comment('纳税国家');
            $table->string("tax_number")->comment("税号");
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
        Schema::dropIfExists('company_tax_info');
    }
}
