<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyAddressContacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_address_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("address_id")->comment("地址id");
            $table->foreign("address_id")->references('id')->on('company_address_info')->onDelete('cascade');
            $table->string("contacts")->nullable(true)->comment("联系人");
            $table->string("tel")->nullable(true)->comment("电话号码"); // 027-123
            $table->string("type")->comment("1中文 2英文");
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
        Schema::dropIfExists('company_address_contacts');
    }
}
