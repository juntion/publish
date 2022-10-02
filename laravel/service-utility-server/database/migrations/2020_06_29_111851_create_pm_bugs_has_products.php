<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugsHasProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bugs_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('bug_id')->comment('bug ID');
            $table->foreign('bug_id')->references('id')->on('pm_bugs')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('产品类型');
            $table->primary(['bug_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_bugs_has_products');
    }
}
