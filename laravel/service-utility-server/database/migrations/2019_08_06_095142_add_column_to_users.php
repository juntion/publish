<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToUsers extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedInteger('admin_level')->nullable()->comment('erp中admin_level');
            $table->unsignedInteger('duties')->default(0)->comment('0; 1:组长;2:主管3组负责人4负责人5经理');
            $table->unsignedInteger('which_language')->default(1)->comment('小语种归属');
            $table->unsignedInteger('is_customer_service')->default(0)->comment('客服所属区域');
            $table->timestamp('update_pass_time')->useCurrent()->comment('密码更新时间');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn('admin_level');
            $table->dropColumn('duties');
            $table->dropColumn('which_language');
            $table->dropColumn('is_customer_service');
            $table->dropColumn('update_pass_time');
        });
    }
}
