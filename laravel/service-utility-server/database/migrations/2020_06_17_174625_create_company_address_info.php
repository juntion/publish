<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyAddressInfo extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_address_info', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger("company_id")->comment("公司id");
            $table->foreign("company_id")->references('id')->on('companies')->onDelete('cascade');
            $table->unsignedTinyInteger("type")->nullable(false)->comment("1 公司地址 2办公室地址 3仓库地址");
            $table->string("name")->default("")->comment("中文名称");
            $table->string("en_name")->default("")->comment("英文名称");
            $table->string("country")->default("")->comment("国家");
            $table->string("province")->default("")->comment("省");
            $table->string("city")->default("")->comment("市");
            $table->string("area")->default("")->comment("区");
            $table->string("address")->default("")->comment("详细地址");
            $table->string("en_country")->default("")->comment("国家(英文)");
            $table->string("en_province")->default("")->comment("省(英文)");
            $table->string("en_city")->default("")->comment("市(英文)");
            $table->string("en_area")->default("")->comment("区(英文)");
            $table->string("en_address")->default("")->comment("详细地址英文)");
            $table->text("comment")->nullable()->comment("简介说明");
            $table->string("postcode")->nullable()->comment("邮编");
            $table->string("en_postcode")->nullable()->comment("邮编(外语)");
            $table->string("tel")->nullable()->comment("电话号码"); // 027-123
            $table->string("en_tel")->nullable()->comment("电话号码(外语)"); // 027-123
            $table->unsignedTinyInteger("status")->default(1)->comment("状态 1 使用中 0 已注销");
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
        Schema::dropIfExists('company_address_info');
    }
}
