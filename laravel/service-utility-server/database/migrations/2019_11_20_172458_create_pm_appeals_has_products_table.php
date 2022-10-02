<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmAppealsHasProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 诉求对应的IT产品
        Schema::create('pm_appeals_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('appeal_id')->comment('诉求ID');
            $table->foreign('appeal_id')->references('id')->on('pm_appeals')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('产品类型');
            $table->primary(['appeal_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_appeals_has_products');
    }
}
