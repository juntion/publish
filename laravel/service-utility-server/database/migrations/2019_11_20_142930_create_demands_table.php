<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDemandsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 需求表
        Schema::create('pm_demands', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedTinyInteger('priority')->comment('优先级;1、2、3、4、5');
            $table->string('number')->default('')->index()->comment('需求编号；XQ+yyyy/mm/dd+001；eg: XQ20191113001');
            $table->string('name')->default('')->comment('需求名称');
            $table->text('content')->nullable()->comment('需求内容');
            $table->unsignedBigInteger('source_project_id')->default(0)->index()->comment('项目来源ID');
            $table->string('source_project_name')->nullable()->comment('项目来源名称');
            $table->date('expiration_date')->nullable()->index()->comment('截至日期');
            $table->unsignedTinyInteger('status')->default(0)
                ->comment('状态；0：待审核；1：审核驳回；2：待推送；3：待指派；4：未处理；5：研发中；6：已提交；7：待测试；8：测试中；9：已完成；10：已暂停；11：已撤销；');
            $table->json('share_address')->nullable()->comment('URL/共享地址');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('需求发布者ID');
            $table->string('promulgator_name')->default('')->comment('需求发布者名称');
            $table->unsignedBigInteger('principal_user_id')->default(0)->index()->comment('产品负责人ID');
            $table->string('principal_user_name')->default('')->comment('产品负责人名称');
            $table->unsignedBigInteger('verify_user_id')->default(0)->nullable()->comment('审核人ID');
            $table->string('verify_user_name')->default('')->comment('审核人名称');
            $table->dateTime('verify_time')->nullable()->comment('审核时间');
            $table->unsignedTinyInteger('confirmed')->default(0)->comment('确认需求；0；待确认；1：已确认；2：存疑；');
            $table->dateTime('start_time')->nullable()->comment('开始时间（任一任务开始，更新日期，后续不再更新）');
            $table->dateTime('finish_time')->nullable()->index()->comment('完成时间（验收完成时更新）');
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
        Schema::dropIfExists('pm_demands');
    }
}
