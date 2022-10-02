<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamMembersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 产品线团队成员
        Schema::create('pm_team_members', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('team_id')->comment('团队ID');
            $table->foreign('team_id')->references('id')->on('pm_teams')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户ID');
            $table->string('user_name')->default('')->comment('用户名');
            $table->unsignedBigInteger('dept_id')->default(0)->index()->comment('部门ID');
            $table->string('dept_name')->default('')->comment('部门名称');
            $table->unsignedTinyInteger('type')->default(0)->comment('人员类型；0：产品；1：交互；2：视觉；3：前端；4：移动端；5：美工；');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_team_members');
    }
}
