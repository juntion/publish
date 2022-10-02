<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddErpBugNumberToPmBugs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_bugs', function (Blueprint $table) {
            $table->string('erp_bug_number')->default('')->after('erp_bug_id')->comment('erp系统中bug编号');
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
            $table->dropColumn('erp_bug_number');
        });
    }
}
