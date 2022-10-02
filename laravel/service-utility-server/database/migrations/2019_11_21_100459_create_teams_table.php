<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTeamsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 产品线对应负责人或团队
        Schema::create('pm_teams', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('product_id')->index()->comment('项目产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedBigInteger('user_id')->default(0)->index()->comment('用户ID');
            $table->string('user_name')->default('')->comment('用户名');
            $table->unsignedBigInteger('dept_id')->default(0)->index()->comment('部门ID');
            $table->string('dept_name')->default('')->comment('部门名称');
            $table->unsignedTinyInteger('type')->default(0)->comment('负责人类型；1：产品；2：设计；3：开发；4：测试；');
            $table->unsignedTinyInteger('is_default')->default(0)->comment('是否默认负责人；1：是；');
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
        Schema::dropIfExists('pm_teams');
    }
}
