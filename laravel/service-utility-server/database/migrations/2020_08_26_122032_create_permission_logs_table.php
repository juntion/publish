<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('permission_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_id')->comment('模型ID');
            $table->string('model_type')->comment('多态模型');
            $table->unsignedBigInteger('user_id')->default(0)->comment('操作人ID');
            $table->string('user_name')->default('')->comment('操作人名称');
            $table->string('action_name')->default('')->comment('操作名称');
            $table->unsignedTinyInteger('type')->nullable()->comment('日志类型：1：角色权限；2：用户角色 3：用户直接权限');
            $table->json('old_value')->default(null)->comment('更新前的值');
            $table->json('new_value')->default(null)->comment('更新后的值');
            $table->string('comment')->default('')->comment('备注');
            $table->index(['model_id', 'model_type']);
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
        Schema::dropIfExists('permission_logs');
    }
}
