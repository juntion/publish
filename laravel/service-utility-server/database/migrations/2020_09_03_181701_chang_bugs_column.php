<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class ChangBugsColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_bugs', function (Blueprint $table) {
            $table->string('comment', 500)->nullable()->comment('备注(跟进人需要注意事项)')->change();
            $table->string('solution', 1000)->nullable()->comment('解决方案')->change();
            $table->string('reason_analyse', 500)->nullable()->comment('原因分析说明')->change();
            $table->string('data_restore_comment', 1000)->nullable()->comment('数据修复情况说明')->change();
            $table->string('inquiry_progress', 500)->nullable()->comment('调查进展')->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_bugs', function (Blueprint $table) {
            $table->string('comment')->nullable()->comment('备注(跟进人需要注意事项)')->change();
            $table->string('solution')->nullable()->comment('解决方案')->change();
            $table->string('reason_analyse')->nullable()->comment('原因分析说明')->change();
            $table->string('data_restore_comment')->nullable()->comment('数据修复情况说明')->change();
            $table->string('inquiry_progress')->nullable()->comment('调查进展')->change();
        });
    }
}
