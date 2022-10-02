<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddErpBugIdToBugs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_bugs', function (Blueprint $table) {
            $table->unsignedBigInteger('erp_bug_id')->default(0)->after('finish_time')->comment('erp系统中bug id');
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
            $table->dropColumn('erp_bug_id');
        });
    }
}
