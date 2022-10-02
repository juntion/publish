<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourcesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_resources', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('creator_uuid', 32)->comment('创建人,admins.uuid');
            $table->char('creator_name', 32)->comment('创建人名,admins.name');
            $table->char('custom_category_uuid', 32)->nullable()->default(null)->comment('资源定制分类的uuid, share_resource_custom_categories.uuid');
            $table->enum('type', ['picture', 'video'])->comment('资源类型，后期可扩展，picture：图片；video：视频');

            $table->string('name')->comment('资源名，文件名，原文件名');
            $table->string('object')->comment('存储路径，oss的资源路径，oss的对象名');
            $table->string('object_height_500_width_930')->comment('按高度500px,宽度930px,进行缩放的缩略图,存储路径，oss的资源路径，oss的对象名');
            $table->string('object_height_216_width_216')->comment('按高度216px,宽度216px,进行缩放的缩略图,存储路径，oss的资源路径，oss的对象名');

            $table->unsignedInteger('size')->comment('资源大小，单位 B，最大支持的文件2147483647B');
            $table->string('mime_type')->default('')->comment('资源格式，mime 类型，image\/jpeg');
            $table->string('format')->default('')->comment('资源格式，JPG，PNG ...');
            $table->unsignedInteger('duration')->default(0)->comment('视频的播放时长，单位：秒，其他资源为0，默认0');

//            $table->string('image_url_height_500_width_930')->default('')->comment('按高度500px,宽度930px,进行缩放的缩略图链接');
//            $table->string('image_url_height_216_width_216')->default('')->comment('按高度216px,宽度216px,进行缩放的缩略图链接');

            $table->unsignedInteger('collection_num')->default(0)->comment('资源被收藏的次数，默认 0');
            $table->unsignedInteger('download_num')->default(0)->comment('资源被下载的次数，默认 0');

            $table->timestamps();

            $table->index('creator_uuid');

            $table->index('created_at');

            $table->foreign('custom_category_uuid')->references('uuid')->on('share_resource_custom_categories')->restrictOnDelete()->cascadeOnUpdate();
        });

        Schema::create('share_resources_logs', function (Blueprint $table) {
            $table->char('uuid', 32);

            $table->json('log')->comment('变更记录，{"title":"日志标题","categories": ["分类1","分类1-1"],"tags": ["标签名1", "标签名2", "标签名3"]}');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->foreign('uuid')->references('uuid')->on('share_resources')->cascadeOnDelete()->cascadeOnUpdate();
        });

        Schema::create('share_resources_to_categories', function (Blueprint $table) {
            $table->char('resource_uuid', 32)->comment('share_resources.uuid');
            $table->char('category_uuid', 32)->comment('share_resource_categories.uuid');

            $table->char('admin_uuid', 32)->comment('设定此资源到分类的人,admins.uuid');
            $table->char('admin_name', 32)->comment('设定此资源到分类的人名,admins.name');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index('admin_uuid');
            $table->unique(['resource_uuid', 'category_uuid']);
            $table->foreign('resource_uuid')->references('uuid')->on('share_resources')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('category_uuid')->references('uuid')->on('share_resource_categories')->restrictOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_resources_to_categories');
        Schema::dropIfExists('share_resources_logs');
        Schema::dropIfExists('share_resources');
    }
}
