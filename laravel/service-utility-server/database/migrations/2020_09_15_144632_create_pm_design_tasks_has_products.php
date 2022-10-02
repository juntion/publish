<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmDesignTasksHasProducts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_design_tasks_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('design_task_id')->comment('设计任务ID');
            $table->foreign('design_task_id')->references('id')->on('pm_design_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('产品类型');
            $table->primary(['design_task_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_design_tasks_has_products');
    }
}
