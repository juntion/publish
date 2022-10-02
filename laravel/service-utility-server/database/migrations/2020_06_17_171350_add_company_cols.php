<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCompanyCols extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table("companies", function (Blueprint $table){
           $table->integer("type")->default("1")->nullable(false)->comment("公司类型 1 母公司 2 子公司 3 分公司");
           $table->unsignedBigInteger("p_id")->index()->default(0)->comment("上级公司，分公司时需要设置");
           $table->string("company_english_name")->default("")->comment("英文名称");
           $table->string("company_simple_name")->default("")->comment("简称");
           $table->string("main_tag")->default("")->comment("主体标识");
           $table->unsignedTinyInteger("is_show")->default(1)->comment("是否展示");
           $table->unsignedTinyInteger("status")->default(1)->comment("公司状态");
           $table->text("profile")->nullable()->comment("公司简介");
           $table->string("country")->comment("公司国家");
           $table->float("time_zone",4, 2)->default(0)->comment("公司时差");
           $table->string("contacts")->default("")->comment("联系人");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('companies', function (Blueprint $table) {
            $table->dropColumn(['type', 'pid', 'company_english_name', 'company_simple_name', 'main_tag', 'is_show', 'status', 'profile', 'time_zone']);
        });
    }
}
