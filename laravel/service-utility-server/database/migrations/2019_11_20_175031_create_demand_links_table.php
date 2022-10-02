<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 需求的研发环节
        Schema::create('pm_demand_links', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('demand_id')->default(0)->comment('需求ID');
            $table->foreign('demand_id')->references('id')->on('pm_demands')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型；1：设计；2：开发；3：测试；');
            $table->unsignedTinyInteger('group')->default(0)->comment('测试参与小组；仅测试环节需要；0：测试团队参与；1：产品自测；');
            $table->unsignedBigInteger('principal_user_id')->default(0)->index()->comment('负责人ID');
            $table->string('principal_user_name')->default('')->comment('负责人名称');
            $table->string('comment', 500)->default('')->comment('产品在各个环节的备注');
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
        Schema::dropIfExists('pm_demand_links');
    }
}
