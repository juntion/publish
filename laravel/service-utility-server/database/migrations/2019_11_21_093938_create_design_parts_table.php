<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignPartsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 设计任务拥有的环节
        Schema::create('pm_design_parts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique()
                ->comment('设计环节任务编号，总任务编号-1；例如设计1019110001-1');
            $table->unsignedBigInteger('task_id')->default(0)->comment('任务ID');
            $table->foreign('task_id')->references('id')->on('pm_design_tasks')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('环节；0：交互；1：视觉；2：美工；3：前端；4：移动端');
            $table->unsignedBigInteger('principal_user_id')->default(0)->index()->comment('负责人ID');
            $table->string('principal_user_name')->default('')->comment('负责人名称');
            $table->unsignedTinyInteger('status')->default(0)
                ->comment('状态；0：关闭中；1：待指派；2：未开始；3：进行中；4：已提交；5：已完成；6：已暂停；7：已撤销；');
            $table->unsignedTinyInteger('stage')->default(1)->comment('阶段；该环节所处的阶段；1、2、3、4、5');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('finish_time')->nullable()->comment('完成时间');
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
        Schema::dropIfExists('pm_design_parts');
    }
}
