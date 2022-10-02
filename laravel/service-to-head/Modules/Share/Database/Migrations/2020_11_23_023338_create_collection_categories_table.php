<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_collection_categories', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('admin_uuid', 32)->comment('分类人，必须和收藏人share_collection_categories.admin_uuid是同一个人,admins.uuid');
            $table->enum('type', ['picture', 'video'])->comment('分类的类型，后期可扩展，picture：图片分类；video：视频分类');

            /** 最高支持四级分类，永不更改
             *  当前分类为一级分类则 parent_uuid == null && uuid == one_level_uuid
             *  当前分类为二级分类则 parent_uuid == one_level_uuid
             *  当前分类为三级分类则 parent_uuid == two_level_uuid
             *  当前分类为四级分类则 parent_uuid == three_level_uuid
             */
            $table->char('parent_uuid', 32)->nullable()->default(null)->comment('父分类uuid, 默认为顶级分类')->index();
            $table->char('one_level_uuid', 32)->nullable()->default(null)->comment('对应的一级分类的uuid')->index();
            $table->char('two_level_uuid', 32)->nullable()->default(null)->comment('对应的二级分类的uuid')->index();
            $table->char('three_level_uuid', 32)->nullable()->default(null)->comment('对应的三级分类的uuid')->index();

            $table->string('name')->default('')->comment('分类名称');
            $table->unsignedTinyInteger('sort')->default(0)->comment('分类的排序');
            $table->unsignedInteger('sum')->default(0)->comment('分类下资源的总个数');

            $table->index('admin_uuid');

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
        Schema::dropIfExists('share_collection_categories');
    }
}
