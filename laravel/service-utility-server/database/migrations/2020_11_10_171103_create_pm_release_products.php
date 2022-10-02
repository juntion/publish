<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmReleaseProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 发版产品表
        Schema::create('pm_release_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('产品名称');
            $table->boolean('status')->default(1)->index()->comment('状态：0:关闭；1:开启');
            $table->unsignedTinyInteger('release_type')->comment('发布周期：1:每周；2：每两周；3：每月');
            $table->unsignedTinyInteger('release_day')->comment('发布时间：星期或日期');
            $table->json('online_address')->nullable()->comment('正式站地址');
            $table->json('testing_address')->nullable()->comment('测试站地址');
            $table->text('description')->nullable()->comment('简介');
            $table->unsignedBigInteger('creator_id')->comment('创建人ID');
            $table->string('creator_name')->comment('创建人名称');
            $table->unsignedBigInteger('updater_id')->comment('更新人ID');
            $table->string('updater_name')->comment('更新人名称');
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
        Schema::dropIfExists('pm_release_products');
    }
}
