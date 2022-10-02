<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugPrincipal extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bug_principal', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('dept_id')->unique()->comment('部门ID');
            $table->foreign('dept_id')->references('id')->on('departments')->onDelete('cascade');
            $table->unsignedBigInteger('backend_program_user_id')->default(0)->comment('后台程序负责任人ID');
            $table->string('backend_program_user_name')->default('')->comment('后台程序负责人名称');
            $table->unsignedBigInteger('frontend_program_user_id')->default(0)->comment('前台程序负责任人ID');
            $table->string('frontend_program_user_name')->default('')->comment('前台程序负责人名称');
            $table->unsignedBigInteger('backend_product_user_id')->default(0)->comment('后台产品负责任人ID');
            $table->string('backend_product_user_name')->default('')->comment('后台产品负责人名称');
            $table->unsignedBigInteger('frontend_product_user_id')->default(0)->comment('前台产品负责任人ID');
            $table->string('frontend_product_user_name')->default('')->comment('前台产品负责人名称');
            $table->unsignedBigInteger('test_user_id')->default(0)->comment('测试负责人ID');
            $table->string('test_user_name')->default('')->comment('测试负责人名称');
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
        Schema::dropIfExists('pm_bug_principal');
    }
}
