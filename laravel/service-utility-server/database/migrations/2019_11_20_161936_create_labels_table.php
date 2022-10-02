<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLabelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 标签表
        Schema::create('pm_labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('label_category_id')->comment('标签类别ID');
            $table->foreign('label_category_id')->references('id')->on('pm_label_categories')->onDelete('cascade');
            $table->string('name')->comment('标签名称');
            $table->unsignedTinyInteger('is_open')->default(0)->comment('是否开启；0：关闭；1：开启');
            $table->string('comment')->default('')->comment('注解');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序');
            $table->string('style')->default('')->comment('标签样式');
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
        Schema::dropIfExists('pm_labels');
    }
}
