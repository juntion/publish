<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagOperationLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_operation_logs', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('tag_data_uuid', 32)->index()->comment('标签uuid');
            $table->char('admin_uuid', 32)->index()->nullable()->default(null)->comment('操作人uuid');
            $table->string('admin_name')->default('')->comment('操作人名称');
            $table->string('action_name')->default('')->comment('操作名称');
            $table->json('properties')->nullable()->default(null)->comment('操作内容');
            $table->string('comment', 500)->default('')->comment('备注');
            $table->text('description')->nullable()->default(null)->comment('操作描述');
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
        Schema::dropIfExists('tag_operation_logs');
    }
}
