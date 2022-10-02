<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToDevTask extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_dev_sub_tasks', function (Blueprint $table) {
            $table->decimal('standard_workload', 5, 1)->nullable()->after('product_confirmed')->comment('考核标准工作量(天)');
            $table->decimal('standard_factor', 2, 1)->nullable()->after('standard_workload')->comment('考核标准系数');
            $table->char('performance_level', 1)->nullable()->after('standard_factor')->comment('绩效等级：S、A、B、C、D');
            $table->smallInteger('offset_days')->nullable()->after('performance_level')->comment('任务偏移天数');
            $table->decimal('offset_factor', 2, 1)->nullable()->after('offset_days')->comment('任务偏移系数');
            $table->string('adjust_reason', 500)->default('')->after('offset_factor')->comment('调整工作量原因');
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
            $table->dropColumn(['standard_workload', 'standard_factor', 'performance_level', 'offset_days', 'offset_factor', 'adjust_reason']);
        });
    }
}
