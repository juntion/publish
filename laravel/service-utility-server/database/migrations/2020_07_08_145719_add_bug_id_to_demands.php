<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddBugIdToDemands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_demands', function (Blueprint $table) {
            $table->unsignedBigInteger('source_bug_id')->nullable()->index()->after('source_project_name')->comment('来源 bug id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_demands', function (Blueprint $table) {
            $table->dropColumn('source_bug_id');
        });
    }
}
