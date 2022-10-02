<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmDemandHasVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 需求预计纳入版本
        Schema::create('pm_demands_has_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('demand_id')->comment('需求ID');
            $table->foreign('demand_id')->references('id')->on('pm_demands')->onDelete('cascade');
            $table->unsignedBigInteger('release_version_id')->comment('版本号ID');
            $table->foreign('release_version_id')->references('id')->on('pm_release_versions')->onDelete('cascade');
            $table->primary(['demand_id', 'release_version_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_demands_has_versions');
    }
}
