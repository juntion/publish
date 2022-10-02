<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddPauseTimeToPmDesignParts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_design_parts', function (Blueprint $table) {
            $table->dateTime('pause_time')->nullable()->after('start_time')->comment('暂停时间');
            $table->unsignedInteger('pause_date')->nullable()->after('pause_time')->comment('暂停累计时间(单位：天)');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_design_parts', function (Blueprint $table) {
            $table->dropColumn(['pause_time', 'pause_date']);
        });
    }
}
