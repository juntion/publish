<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmDevTaskHasVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 开发任务预计纳入版本
        Schema::create('pm_dev_tasks_has_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('dev_task_id')->comment('开发总任务ID');
            $table->foreign('dev_task_id')->references('id')->on('pm_dev_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('release_version_id')->comment('版本号ID');
            $table->foreign('release_version_id')->references('id')->on('pm_release_versions')->onDelete('cascade');
            $table->primary(['dev_task_id', 'release_version_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_dev_tasks_has_versions');
    }
}
