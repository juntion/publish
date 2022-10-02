<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumnToLoginTracks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('login_tracks', function (Blueprint $table) {
            $table->string('city')->default('')->after('ip_address')->comment('登录地区');
            $table->string('browser')->default('')->after('ip_address')->comment('登录浏览器');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('login_tracks', function (Blueprint $table) {
            $table->dropColumn('city');
            $table->dropColumn('browser');
        });
    }
}
