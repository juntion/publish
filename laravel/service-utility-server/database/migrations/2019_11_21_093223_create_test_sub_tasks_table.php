<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTestSubTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 测试子任务表
        Schema::create('pm_test_sub_tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->unique()->comment('子任务编号，总任务编号-1；例如设计1019110001-1');
            $table->unsignedBigInteger('task_id')->comment('总任务ID');
            $table->foreign('task_id')->references('id')->on('pm_test_tasks')->onDelete('cascade');
            $table->unsignedTinyInteger('priority')->default(0)->comment('优先级；1、2、3、4、5；');
            $table->date('expiration_date')->nullable()->comment('截止日期');
            $table->string('description', 500)->default('')->comment('任务描述');
            $table->unsignedBigInteger('handler_id')->default(0)->index()->comment('处理人ID');
            $table->string('handler_name')->default('')->comment('处理人名称');
            $table->json('share_address')->nullable()->comment('URL/共享地址');
            $table->unsignedTinyInteger('status')->default(0)
                ->comment('状态；0：待测试；1：测试中；2：已完成；3：已暂停；4：已撤销；5：已提交；6：待发布；7：关闭中');
            $table->unsignedTinyInteger('result')->default(0)
                ->comment('测试结果；0：无故障；1：故障已全部解决；2：故障未全部解决；');
            $table->text('feedback')->nullable()->comment('测试反馈');
            $table->unsignedTinyInteger('is_main')->default(0)->comment('否主处理人的任务；1：是；');
            $table->dateTime('start_time')->nullable()->comment('开始时间');
            $table->dateTime('finish_time')->nullable()->comment('完成时间');
            $table->dateTime('submit_time')->nullable()->comment('提交时间');
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
        Schema::dropIfExists('pm_test_sub_tasks');
    }
}
