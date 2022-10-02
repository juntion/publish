<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmProjectPrincipalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 项目对应IT产品的负责人
        Schema::create('pm_project_principals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('project_id')->comment('项目ID');
            $table->foreign('project_id')->references('id')->on('pm_projects')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户ID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('user_name')->default('')->comment('用户名称');
            $table->unsignedBigInteger('dept_id')->default(0)->comment('部门ID');
            $table->string('dept_name')->default('')->comment('部门名称');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型；0：产品；1：设计；2：开发；3：业务；4：测试；');
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
        Schema::dropIfExists('pm_project_principals');
    }
}
