<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReleaseStatusToSubtasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_design_sub_tasks', function (Blueprint $table) {
            $table->unsignedTinyInteger('release_status')->nullable()->after('product_confirmed')
                ->comment('发布状态：1：未发布测试；2：已发布测试');
        });

        Schema::table('pm_dev_sub_tasks', function (Blueprint $table) {
            $table->unsignedTinyInteger('release_status')->nullable()->after('product_confirmed')
                ->comment('发布状态：1：未发布测试；2：已发布测试');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_design_sub_tasks', function (Blueprint $table) {
            $table->dropColumn('release_status');
        });

        Schema::table('pm_dev_sub_tasks', function (Blueprint $table) {
            $table->dropColumn('release_status');
        });
    }
}
