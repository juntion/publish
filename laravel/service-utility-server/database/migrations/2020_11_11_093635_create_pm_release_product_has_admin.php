<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmReleaseProductHasAdmin extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 发版产品关联管理员表
        Schema::create('pm_release_product_has_admin', function (Blueprint $table) {
            $table->unsignedBigInteger('release_product_id')->comment('发版产品ID');
            $table->foreign('release_product_id')->references('id')->on('pm_release_products')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->comment('管理员ID');
            $table->string('user_name')->comment('管理员名称');
            $table->primary(['release_product_id', 'user_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_release_product_has_admin');
    }
}
