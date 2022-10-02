<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmReleaseProductHasProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 发版产品关联pms产品(线)
        Schema::create('pm_release_product_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('release_product_id')->comment('发版产品ID');
            $table->foreign('release_product_id')->references('id')->on('pm_release_products')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('pms产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('product_type')->default(0)->comment('产品类型：0：产品线；1：产品；2：模块；3：类别；');
            $table->primary(['release_product_id', 'product_id'], 'release_product_id_product_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_release_product_has_products');
    }
}
