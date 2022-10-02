<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddReviewUserToDesignTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('pm_design_tasks', function (Blueprint $table) {
            $table->unsignedBigInteger('reviewer_id')->default(0)->comment('设计走查人ID')->after('review');
            $table->string('reviewer_name')->default('')->comment('走查人名称')->after('reviewer_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('pm_design_tasks', function (Blueprint $table) {
            $table->dropColumn(['reviewer_id', 'reviewer_name']);
        });
    }
}
