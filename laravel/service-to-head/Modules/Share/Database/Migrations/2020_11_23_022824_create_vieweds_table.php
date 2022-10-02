<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateViewedsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 资源访问记录，每个用户保留三个月以内的最新的200条，每周定时任务清理
        Schema::create('share_vieweds', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('admin_uuid', 32)->comment('访问人,admins.uuid');
            $table->char('resource_uuid', 32)->comment('访问的资源 share_resources.uuid');
            $table->char('resource_name')->comment('访问的资源名 share_resources.name');
            $table->enum('resource_type', ['picture', 'video'])->comment('资源类型，后期可扩展，picture：图片；video：视频，share_resources.type');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->index('admin_uuid');
            $table->index('resource_uuid');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_vieweds');
    }
}
