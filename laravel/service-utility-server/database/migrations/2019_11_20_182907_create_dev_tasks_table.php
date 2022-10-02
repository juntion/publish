<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDevTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 开发任务表
        Schema::create('pm_dev_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique()
                ->comment('任务编号（设计10，开发20，测试30）环节代码+YY+MM+0001（四位流水号）；例如设计1019110001');
            $table->unsignedBigInteger('demand_id')->nullable()->index()->comment('需求ID');
            $table->unsignedBigInteger('source_project_id')->default(0)->index()->comment('项目来源ID');
            $table->foreign('demand_id')->references('id')->on('pm_demands')->onDelete('cascade');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('发布人ID');
            $table->string('promulgator_name')->default('')->comment('发布人名称');
            $table->unsignedBigInteger('principal_user_id')->index()->default(0)->comment('负责人ID');
            $table->string('principal_user_name')->default('')->comment('负责人名称');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->index()->comment('截至日期');
            $table->text('content')->nullable()->comment('任务描述');
            $table->unsignedTinyInteger('status')->default(0)
                ->comment('状态；0：关闭中；1：待指派；2：未开始；3：进行中；4：已提交；5：已完成；6：已暂停；7：已撤销；');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('finish_time')->nullable()->index()->comment('完成时间');
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
        Schema::dropIfExists('pm_dev_tasks');
    }
}
