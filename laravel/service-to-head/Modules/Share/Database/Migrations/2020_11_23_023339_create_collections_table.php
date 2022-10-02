<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCollectionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_collections', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('admin_uuid', 32)->comment('收藏人,admins.uuid');
            $table->char('resource_uuid', 32)->comment('收藏的资源 share_resources.uuid');
            $table->enum('resource_type', ['picture', 'video'])->comment('资源类型，后期可扩展，picture：图片；video：视频，share_resources.type');
            $table->char('resource_name')->comment('收藏的资源名称 share_resources.name');
            $table->char('category_uuid', 32)->nullable()->default(null)->comment('资源收藏分类的uuid,默认为空字符串 顶级分类，, share_collection_categories.uuid');

            $table->unique(['admin_uuid', 'resource_uuid']);
            $table->index('resource_uuid');

            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->foreign('category_uuid')->references('uuid')->on('share_collection_categories')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_collections');
    }
}
