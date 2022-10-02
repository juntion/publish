<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLabelCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 标签分类表
        Schema::create('pm_label_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('类别名称');
            $table->unsignedTinyInteger('is_open')->default(0)->comment('是否开启；0：关闭；1：开启；');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序');
            $table->string('style')->default('')->comment('样式');
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
        Schema::dropIfExists('pm_label_categories');
    }
}
