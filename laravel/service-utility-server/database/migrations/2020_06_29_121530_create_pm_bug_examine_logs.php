<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugExamineLogs extends Migration
{
    /**
     * Bug 审批日志.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bug_examine_logs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bug_id')->index()->comment('bug ID');
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
        Schema::dropIfExists('pm_bug_examine_logs');
    }
}
