<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddFinishTypeToDevSubTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_dev_sub_tasks', function (Blueprint $table) {
            $table->unsignedTinyInteger('finish_type')->nullable()->after('finish_time')->comment('完成情况：1：按时完成；2：提前完成；3：超时完成');
            $table->string('difference_reason')->default('')->after('finish_type')->comment('差异原因说明');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_dev_sub_tasks', function (Blueprint $table) {
            $table->dropColumn(['finish_type', 'difference_reason']);
        });
    }
}
