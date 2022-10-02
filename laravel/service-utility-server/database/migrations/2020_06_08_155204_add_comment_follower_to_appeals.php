<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddCommentFollowerToAppeals extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_appeals', function (Blueprint $table) {
            $table->string('comment_follower')->default('')->after('comment')->comment('跟进人备注');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_appeals', function (Blueprint $table) {
            $table->dropColumn('comment_follower');
        });
    }
}
