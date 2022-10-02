<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToDevSubTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_dev_sub_tasks', function (Blueprint $table) {
            $table->unsignedTinyInteger('release_type')->nullable()->after('submit_time')
                ->comment('发布类型：0：跟随版本发布；1：hotfix上线；2：无需发布');
            $table->string('branch_name')->nullable()->default('')->after('release_type')->comment('分支名称');
            $table->boolean('has_sql')->nullable()->after('branch_name')->comment('有无SQL：0:无； 1:有');
            $table->unsignedBigInteger('release_version_id')->index()->nullable()->after('has_sql')->comment('版本号ID');
            $table->boolean('stress_test')->nullable()->index()->after('release_version_id')->comment('是否需要压力测试：0:不需要；1:需要');
            $table->string('release_comment')->nullable()->default('')->after('stress_test')->comment('发版信息说明');
            $table->boolean('product_confirmed')->nullable()->index()->after('release_comment')->comment('产品确认：0:未确认；1:已确认');
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
            $table->dropColumn([
                'release_type',
                'branch_name',
                'has_sql',
                'release_version_id',
                'stress_test',
                'release_comment',
                'product_confirmed',
            ]);
        });
    }
}
