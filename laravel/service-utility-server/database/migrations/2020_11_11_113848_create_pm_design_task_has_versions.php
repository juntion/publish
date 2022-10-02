<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmDesignTaskHasVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 设计任务预计纳入版本
        Schema::create('pm_design_tasks_has_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('design_task_id')->comment('设计总任务ID');
            $table->foreign('design_task_id')->references('id')->on('pm_design_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('release_version_id')->comment('版本号ID');
            $table->foreign('release_version_id')->references('id')->on('pm_release_versions')->onDelete('cascade');
            $table->primary(['design_task_id', 'release_version_id'], 'design_task_id_release_version_id_primary');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_design_tasks_has_versions');
    }
}
