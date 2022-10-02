<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePmFrontAndMobileTasks extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 前端主任务
        Schema::create('pm_frontend_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()
                ->comment('任务编号（前端40）环节代码+YY+MM+0001（四位流水号）；例如设计4019110001');
            $table->string('title')->default('')->comment('任务标题');
            $table->unsignedBigInteger('demand_id')->nullable()->index()->comment('需求ID');
            $table->foreign('demand_id')->references('id')->on('pm_demands')->onDelete('cascade');
            $table->unsignedBigInteger('source_project_id')->default(0)->index()->comment('项目来源ID');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('发布人ID');
            $table->string('promulgator_name')->default('')->comment('发布人名称');
            $table->unsignedBigInteger('main_principal_user_id')->default(0)->index()->comment('主负责人ID');
            $table->string('main_principal_user_name')->default('')->comment('主负责人名称');
            $table->unsignedBigInteger('principal_user_id')->index()->default(0)->comment('负责人ID');
            $table->string('principal_user_name')->default('')->comment('负责人名称');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->index()->comment('截至日期');
            $table->text('content')->nullable()->comment('任务描述');
            $table->json('share_address')->nullable()->comment('共享地址');
            $table->unsignedTinyInteger('status')->default(0)->index()
                ->comment('状态；0：关闭中；1：待指派；2：未开始；3：进行中；4：已提交；5：已完成；6：已暂停；7：已撤销；8：待审核');
            $table->char('level', 1)->nullable()->comment('任务等级：S、A、B、C、D');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('finish_time')->nullable()->index()->comment('完成时间');
            $table->dateTime('pause_time')->nullable()->comment('暂停时间');
            $table->unsignedInteger('pause_date')->nullable()->comment('暂停累计时间(单位：天)');
            $table->timestamps();
        });
        // 前端子任务
        Schema::create('pm_frontend_sub_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->comment('子任务编号，总任务编号-1；例如设计4019110001-1');
            $table->unsignedBigInteger('task_id')->comment('总任务ID');
            $table->foreign('task_id')->references('id')->on('pm_frontend_tasks')->onDelete('cascade');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->comment('截止日期');
            $table->string('description', 500)->default('')->comment('任务描述');
            $table->unsignedBigInteger('handler_id')->default(0)->index()->comment('处理人ID');
            $table->string('handler_name')->default('')->comment('处理人名称');
            $table->json('share_address')->nullable()->comment('URL/共享地址');
            $table->unsignedTinyInteger('status')->default(0)->index()
                ->comment('状态；0：未开始；1：进行中；2：已提交；3：已完成；4：已暂停；5：已撤销；6：关闭中');
            $table->unsignedTinyInteger('is_main')->default(0)->comment('否主处理人的任务；1：是；');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('pause_time')->nullable()->comment('暂停时间');
            $table->unsignedInteger('pause_date')->nullable()->comment('暂停累计时间(单位：天)');
            $table->dateTime('submit_time')->nullable()->comment('提交时间');
            $table->dateTime('finish_time')->nullable()->comment('完成时间');
            $table->unsignedTinyInteger('finish_type')->nullable()->comment('完成情况：1：按时完成；2：提前完成；3：超时完成');
            $table->string('difference_reason')->default('')->comment('差异原因说明');
            $table->unsignedTinyInteger('release_type')->nullable()->comment('发布类型：0：跟随版本发布；1：hotfix上线；2：无需发布');
            $table->string('branch_name')->nullable()->default('')->comment('分支名称');
            $table->boolean('has_sql')->nullable()->comment('有无SQL：0:无； 1:有');
            $table->unsignedBigInteger('release_version_id')->index()->nullable()->comment('版本号ID');
            $table->boolean('stress_test')->nullable()->index()->comment('是否需要压力测试：0:不需要；1:需要');
            $table->string('release_comment')->nullable()->default('')->comment('发版信息说明');
            $table->boolean('product_confirmed')->nullable()->index()->comment('产品确认：0:未确认；1:已确认');
            $table->unsignedTinyInteger('release_status')->nullable()->comment('发布状态：1：未发布测试；2：已发布测试');
            $table->decimal('standard_workload', 5, 1)->nullable()->comment('考核标准工作量(天)');
            $table->decimal('standard_factor', 2, 1)->nullable()->comment('考核标准系数');
            $table->char('performance_level', 1)->nullable()->comment('绩效等级：S、A、B、C、D');
            $table->smallInteger('offset_days')->nullable()->comment('任务偏移天数');
            $table->decimal('offset_factor', 2, 1)->nullable()->comment('任务偏移系数');
            $table->string('adjust_reason', 500)->default('')->comment('调整工作量原因');
            $table->timestamps();
        });
        // 前端关联产品
        Schema::create('pm_frontend_tasks_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('frontend_task_id')->comment('前端任务ID');
            $table->foreign('frontend_task_id')->references('id')->on('pm_frontend_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('产品类型');
            $table->primary(['frontend_task_id', 'product_id'], 'frontend_task_id_product_id_primary');
        });
        // 前端关联发版
        Schema::create('pm_frontend_tasks_has_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('frontend_task_id')->comment('前端总任务ID');
            $table->foreign('frontend_task_id')->references('id')->on('pm_frontend_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('release_version_id')->comment('版本号ID');
            $table->foreign('release_version_id')->references('id')->on('pm_release_versions')->onDelete('cascade');
            $table->primary(['frontend_task_id', 'release_version_id'], 'frontend_task_id_release_version_id_primary');
        });


        // 移动端主任务
        Schema::create('pm_mobile_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()
                ->comment('任务编号（移动端50）环节代码+YY+MM+0001（四位流水号）；例如设计5019110001');
            $table->string('title')->default('')->comment('任务标题');
            $table->unsignedBigInteger('demand_id')->nullable()->index()->comment('需求ID');
            $table->foreign('demand_id')->references('id')->on('pm_demands')->onDelete('cascade');
            $table->unsignedBigInteger('source_project_id')->default(0)->index()->comment('项目来源ID');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('发布人ID');
            $table->string('promulgator_name')->default('')->comment('发布人名称');
            $table->unsignedBigInteger('main_principal_user_id')->default(0)->index()->comment('主负责人ID');
            $table->string('main_principal_user_name')->default('')->comment('主负责人名称');
            $table->unsignedBigInteger('principal_user_id')->index()->default(0)->comment('负责人ID');
            $table->string('principal_user_name')->default('')->comment('负责人名称');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->index()->comment('截至日期');
            $table->text('content')->nullable()->comment('任务描述');
            $table->json('share_address')->nullable()->comment('共享地址');
            $table->unsignedTinyInteger('status')->default(0)->index()
                ->comment('状态；0：关闭中；1：待指派；2：未开始；3：进行中；4：已提交；5：已完成；6：已暂停；7：已撤销；8：待审核');
            $table->char('level', 1)->nullable()->comment('任务等级：S、A、B、C、D');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('finish_time')->nullable()->index()->comment('完成时间');
            $table->dateTime('pause_time')->nullable()->comment('暂停时间');
            $table->unsignedInteger('pause_date')->nullable()->comment('暂停累计时间(单位：天)');
            $table->timestamps();
        });
        // 移动端子任务
        Schema::create('pm_mobile_sub_tasks', function (Blueprint $table) {
            $table->id();
            $table->string('number')->unique()->comment('子任务编号，总任务编号-1；例如设计5019110001-1');
            $table->unsignedBigInteger('task_id')->comment('总任务ID');
            $table->foreign('task_id')->references('id')->on('pm_mobile_tasks')->onDelete('cascade');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->comment('截止日期');
            $table->string('description', 500)->default('')->comment('任务描述');
            $table->unsignedBigInteger('handler_id')->default(0)->index()->comment('处理人ID');
            $table->string('handler_name')->default('')->comment('处理人名称');
            $table->json('share_address')->nullable()->comment('URL/共享地址');
            $table->unsignedTinyInteger('status')->default(0)->index()
                ->comment('状态；0：未开始；1：进行中；2：已提交；3：已完成；4：已暂停；5：已撤销；6：关闭中');
            $table->unsignedTinyInteger('is_main')->default(0)->comment('否主处理人的任务；1：是；');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('pause_time')->nullable()->comment('暂停时间');
            $table->unsignedInteger('pause_date')->nullable()->comment('暂停累计时间(单位：天)');
            $table->dateTime('submit_time')->nullable()->comment('提交时间');
            $table->dateTime('finish_time')->nullable()->comment('完成时间');
            $table->unsignedTinyInteger('finish_type')->nullable()->comment('完成情况：1：按时完成；2：提前完成；3：超时完成');
            $table->string('difference_reason')->default('')->comment('差异原因说明');
            $table->unsignedTinyInteger('release_type')->nullable()->comment('发布类型：0：跟随版本发布；1：hotfix上线；2：无需发布');
            $table->string('branch_name')->nullable()->default('')->comment('分支名称');
            $table->boolean('has_sql')->nullable()->comment('有无SQL：0:无； 1:有');
            $table->unsignedBigInteger('release_version_id')->index()->nullable()->comment('版本号ID');
            $table->boolean('stress_test')->nullable()->index()->comment('是否需要压力测试：0:不需要；1:需要');
            $table->string('release_comment')->nullable()->default('')->comment('发版信息说明');
            $table->boolean('product_confirmed')->nullable()->index()->comment('产品确认：0:未确认；1:已确认');
            $table->unsignedTinyInteger('release_status')->nullable()->comment('发布状态：1：未发布测试；2：已发布测试');
            $table->decimal('standard_workload', 5, 1)->nullable()->comment('考核标准工作量(天)');
            $table->decimal('standard_factor', 2, 1)->nullable()->comment('考核标准系数');
            $table->char('performance_level', 1)->nullable()->comment('绩效等级：S、A、B、C、D');
            $table->smallInteger('offset_days')->nullable()->comment('任务偏移天数');
            $table->decimal('offset_factor', 2, 1)->nullable()->comment('任务偏移系数');
            $table->string('adjust_reason', 500)->default('')->comment('调整工作量原因');
            $table->timestamps();
        });
        // 移动端关联产品
        Schema::create('pm_mobile_tasks_has_products', function (Blueprint $table) {
            $table->unsignedBigInteger('mobile_task_id')->comment('前端任务ID');
            $table->foreign('mobile_task_id')->references('id')->on('pm_mobile_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('product_id')->comment('产品ID');
            $table->foreign('product_id')->references('id')->on('pm_products')->onDelete('cascade');
            $table->unsignedTinyInteger('type')->default(0)->comment('产品类型');
            $table->primary(['mobile_task_id', 'product_id'], 'mobile_task_id_product_id_primary');
        });
        // 移动端关联发版
        Schema::create('pm_mobile_tasks_has_versions', function (Blueprint $table) {
            $table->unsignedBigInteger('mobile_task_id')->comment('前端总任务ID');
            $table->foreign('mobile_task_id')->references('id')->on('pm_mobile_tasks')->onDelete('cascade');
            $table->unsignedBigInteger('release_version_id')->comment('版本号ID');
            $table->foreign('release_version_id')->references('id')->on('pm_release_versions')->onDelete('cascade');
            $table->primary(['mobile_task_id', 'release_version_id'], 'mobile_task_id_release_version_id_primary');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_frontend_tasks_has_versions');
        Schema::dropIfExists('pm_frontend_tasks_has_products');
        Schema::dropIfExists('pm_frontend_sub_tasks');
        Schema::dropIfExists('pm_frontend_tasks');

        Schema::dropIfExists('pm_mobile_tasks_has_versions');
        Schema::dropIfExists('pm_mobile_tasks_has_products');
        Schema::dropIfExists('pm_mobile_sub_tasks');
        Schema::dropIfExists('pm_mobile_tasks');
    }
}
