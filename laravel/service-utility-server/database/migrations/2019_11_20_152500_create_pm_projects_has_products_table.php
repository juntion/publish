<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmProjectsHasProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 项目对应的IT产品
        Schema::create('pm_projects_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('project_id')->comment('项目ID');
            $table->foreign('project_id')->references('id')->on('pm_projects')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('项目产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('product_type')->default(0)->comment('产品类型');
            $table->primary(['project_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_projects_has_products');
    }
}
