<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebar_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->bigInteger('parent_id')->default(0)->comment('父ID');
            $table->unsignedBigInteger('sidebar_template_id')->index()->comment('侧边栏模板ID');
            $table->foreign('sidebar_template_id')->references('id')->on('sidebar_templates')->onDelete('cascade');
            $table->string('name')->default('')->comment('分类名');
            $table->string('comment')->default('')->comment('备注信息');
            $table->json('locale')->nullable()->comment('多语言');
            $table->integer('sort')->default(0)->comment('排序');
            $table->string('icon')->default('')->comment('图标');
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
        Schema::dropIfExists('sidebar_categories');
    }
}
