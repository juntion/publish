<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDesignTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_design_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique()
                ->comment('任务编号（设计10，开发20，测试30）环节代码+YY+MM+0001（四位流水号）；例如设计1019110001');
            $table->unsignedBigInteger('demand_id')->nullable()->index()->comment('需求ID');
            $table->unsignedBigInteger('source_project_id')->default(0)->index()->comment('项目来源ID');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('发布人ID');
            $table->string('promulgator_name')->default('')->comment('发布人名称');
            $table->unsignedBigInteger('principal_user_id')->default(0)->index()->comment('负责人ID');
            $table->string('principal_user_name')->default('')->comment('负责人名称');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->index()->comment('截至日期');
            $table->text('content')->nullable()->comment('任务描述');
            $table->unsignedTinyInteger('status')->default(1)
                ->comment('状态；0：关闭中；1：待审核；2：待指派；3：未开始；4：进行中；5：已提交；6：已完成；7：已暂停；8：已撤销；');
            $table->unsignedTinyInteger('review')->default(1)
                ->comment('设计走查；0：不需要走查；1：需要走查；2：待走查；3：待确认；4：已确认');
            $table->unsignedTinyInteger('review_result')->nullable()
                ->comment('设计走查结果；0：无差异；1：差异已调整；2：差异未全部调整；');
            $table->string('review_comment', 500)->nullable()->comment('设计走查备注');
            $table->dateTime('review_time')->nullable()->comment('走查时间');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('finish_time')->nullable()->index()->comment('完成时间');
            $table->dateTime('verify_time')->nullable()->index()->comment('审核时间');
            $table->unsignedTinyInteger('design_type')->nullable()->comment('设计类型；0：分阶段设计；1：同时设计；2：设计优先；');
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
        Schema::dropIfExists('pm_design_tasks');
    }
}
