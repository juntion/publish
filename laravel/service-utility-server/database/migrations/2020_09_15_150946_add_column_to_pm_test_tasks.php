<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToPmTestTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_test_tasks', function (Blueprint $table) {
            $table->string('title')->default('')->after('number')->comment('任务标题');
            $table->json('share_address')->nullable()->after('content')->comment('共享地址');
            $table->unsignedBigInteger('main_principal_user_id')->default(0)->after('promulgator_name')->comment('主负责人ID');
            $table->string('main_principal_user_name')->default('')->after('main_principal_user_id')->comment('主负责人名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_test_tasks', function (Blueprint $table) {
            $table->dropColumn(['title', 'share_address', 'main_principal_user_id', 'main_principal_user_name']);
        });
    }
}
