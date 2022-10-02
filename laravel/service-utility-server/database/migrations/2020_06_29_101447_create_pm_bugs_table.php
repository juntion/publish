<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bugs', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique()->comment('bug编号');
            $table->unsignedBigInteger('dept_id')->comment('发布人部门ID');
            $table->string('dept_name')->comment('发布人部门名称');
            $table->unsignedBigInteger('promulgator_id')->comment('发布人ID');
            $table->string('promulgator_name')->comment('发布人名称');
            $table->unsignedTinyInteger('status')->default(0)
                ->comment('状态 0：待指派；1：待受理；2：处理中；3：待复核；4：排期中；5：已处理；6：不处理；7：已撤销；8：申请审批；');
            $table->unsignedTinyInteger('examine_status')->nullable()
                ->comment('审批状态 1：待财务审批；2：财务审批通过；3：财务审批驳回；4：待内控审批；5：内控审批通过；6：内控审批驳回');
            $table->unsignedTinyInteger('is_urgent')->default(0)->comment('是否加急 0：不加急，1：加急');
            $table->text('description')->comment('故障描述');
            $table->json('operation_account')->comment('操作账号');
            $table->json('browser')->nullable()->comment('故障浏览器');
            $table->unsignedTinyInteger('operation_platform')->comment('操作平台 1：前台PC端；2：后台PC端；3：PDA；4：APP');
            $table->json('links')->nullable()->comment('页面链接');
            $table->string('version')->nullable()->comment('软件版本号');
            $table->dateTime('start_time')->comment('故障开始时间');
            $table->dateTime('end_time')->nullable()->comment('故障结束时间');
            $table->unsignedBigInteger('source_project_id')->nullable()->comment('所属项目ID');
            $table->string('source_project_name')->nullable()->comment('所属项目名称');
            $table->unsignedBigInteger('source_demand_id')->nullable()->comment('所属需求ID');
            $table->string('source_demand_name')->nullable()->comment('所属需求名称');
            $table->unsignedBigInteger('product_principal_id')->comment('产品负责人ID');
            $table->string('product_principal_name')->comment('产品负责人名称');
            $table->unsignedBigInteger('program_principal_id')->comment('程序负责人ID');
            $table->string('program_principal_name')->comment('程序负责人名称');
            $table->unsignedBigInteger('test_principal_id')->comment('测试负责人ID');
            $table->string('test_principal_name')->comment('测试负责人名称');
            $table->date('expiration_date')->nullable()->comment('截至日期');
            $table->string('comment')->nullable()->comment('备注(跟进人需要注意事项)');
            $table->unsignedTinyInteger('resolve_status')->nullable()->comment('问题解决状态 2：处理中；4：排期中；5：已处理；6：不处理');
            $table->string('solution')->nullable()->comment('解决方案');
            $table->unsignedBigInteger('reason_id')->nullable()->comment('原因类型');
            $table->string('reason_analyse')->nullable()->comment('原因分析说明');
            $table->unsignedTinyInteger('data_restore')->nullable()->comment('数据修复情况 1：未修复；2：已修复；3：无需程序修复；4：程序无法修复');
            $table->string('data_restore_comment')->nullable()->comment('数据修复情况说明');
            $table->string('inquiry_progress')->nullable()->comment('调查进展');
            $table->dateTime('start_handle_time')->nullable()->comment('开始处理时间');
            $table->dateTime('submit_time')->nullable()->comment('提交时间');
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
        Schema::dropIfExists('pm_bugs');
    }
}
