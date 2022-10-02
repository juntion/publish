<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmDemandsHasProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 需求对应的IT产品
        Schema::create('pm_demands_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('demand_id')->comment('需求ID');
            $table->foreign('demand_id')->references('id')->on('pm_demands')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('product_type')->default(0)->comment('产品类型');
            $table->primary(['demand_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_demands_has_products');
    }
}
