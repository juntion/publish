<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCompanyStatusLog extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 状态日志表
        Schema::create('company_status_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('model_id')->index()->comment('模型ID');
            $table->string('model_type')->index()->comment('多态类型');
            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('操作人ID');
            $table->string('user_name')->default('')->comment('操作人名称');
            $table->string('action_name')->default('')->comment('操作名称');
            $table->unsignedTinyInteger('old_status')->nullable()->comment('更新前的状态');
            $table->unsignedTinyInteger('new_status')->default(0)->comment('更新后的状态');
            $table->string('comment')->default('')->comment('备注');
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
        Schema::dropIfExists('company_status_logs');
    }
}
