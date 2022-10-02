<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddLevelToDemands extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_demands', function (Blueprint $table) {
            $table->char('level', 1)->default('D')->after('number')->comment('需求级别：S、A、B、C、D');
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
            $table->dropColumn('level');
        });
    }
}
