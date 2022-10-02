<?php

use App\Enums\ProjectManage\AppealStatus;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppealsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 诉求表
        Schema::create('pm_appeals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->index()->comment('诉求编号；SQ+yyyy/mm/dd+001；eg: SQ20191113001');
            $table->string('name')->comment('诉求名称');
            $table->text('content')->nullable()->comment('诉求内容');
            $table->string('brief', 500)->default('')->comment('诉求内容简介');
            $table->unsignedTinyInteger('type')->default(0)
                ->comment('诉求类型；1：规则调整；2：新增功能；3：迭代建议；4：数据提取；5：Bug修复；');
            $table->unsignedTinyInteger('is_urgent')->default(0)->comment('是否紧急；1：紧急；');
            $table->unsignedTinyInteger('is_important')->default(0)->comment('是否重要；1：重要');
            $table->unsignedBigInteger('source_project_id')->default(0)->index()->comment('来源项目ID');
            $table->string('source_project_name')->nullable()->comment('项目来源名称');
            $table->date('expiration_date')->nullable()->index()->comment('截至日期');
            $table->unsignedTinyInteger('status')->default(AppealStatus::STATUS_TO_DISTRIBUTION)
                ->comment('诉求状态；0：待受理；1：跟进中；2：排期中；3：立项待审核；4：已立项；5：已完成；6：已驳回；7：已撤销；8:待分配；');
            $table->unsignedBigInteger('dept_id')->default(0)->comment('诉求人部门ID');
            $table->string('dept_name')->default('')->comment('诉求人部门名称');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('发布人ID');
            $table->string('promulgator_name')->default('')->comment('发布人名称');
            $table->unsignedBigInteger('principal_user_id')->default(0)->index()->comment('产品负责人ID');
            $table->string('principal_user_name')->default('')->comment('产品负责人名称');
            $table->unsignedBigInteger('follower_id')->default(0)->index()->comment('产品跟进人ID');
            $table->string('follower_name')->default('')->comment('产品跟进人名称');
            $table->dateTime('follow_time')->nullable()->comment('开始跟进时间');
            $table->unsignedTinyInteger('follow_type')->default(0)->comment('跟进类型；0；自主跟进；1；负责人指派；');
            $table->unsignedBigInteger('verify_user_id')->default(0)->comment('审核人ID');
            $table->string('verify_user_name')->default('')->comment('审核人名称');
            $table->dateTime('verify_time')->nullable()->comment('审核时间');
            $table->string('comment')->default('')->comment('备注');
            $table->unsignedBigInteger('origin_id')->default(0)->index()->comment('原始诉求ID');
            $table->unsignedBigInteger('demand_id')->default(0)->index()->comment('关联的需求ID');
            $table->json('questions')->nullable()->comment('诉求问题及答案，键值为 urgent 是选择紧急时的问题，键值为 important 是选择重要时的问题');
            $table->string('crux', 500)->default('')->comment('症结点');
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
        Schema::dropIfExists('pm_appeals');
    }
}
