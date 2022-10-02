<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 项目表
        Schema::create('pm_projects', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->default('')->index()->comment('项目编号；XM+yyyy/mm/dd+001；eg: XM20191113001');
            $table->string('name')->default('')->comment('项目名称');
            $table->unsignedTinyInteger('type')->default(0)->comment('项目类型；0：日常项目；1：重点项目；');
            $table->unsignedBigInteger('principal_user_id')->default(0)->index()->comment('项目负责人ID');
            $table->string('principal_user_name')->default('')->comment('项目负责人名称');
            $table->date('expiration_date')->nullable()->index()->comment('项目截止日期');
            $table->text('contents')->nullable()->comment('项目描述');
            $table->unsignedTinyInteger('status')->default(0)
                ->comment('项目状态；0：关闭中；1：开启中；2：暂停中；3：已完成；4：已撤销；');
            $table->json('shared_address')->nullable()->comment('共享地址或URL地址');
            $table->unsignedBigInteger('promulgator_id')->default(0)->index()->comment('发布人ID');
            $table->string('promulgator_name')->default('')->comment('发布人名称');
            $table->string('comment')->default('')->comment('项目备注');
            $table->char('level', 1)->default('D')->comment('项目级别；S、A、B、C、D');
            $table->unsignedTinyInteger('difficulty')->default(1)->comment('项目难度；1、2、3、4、5');
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
        Schema::dropIfExists('pm_projects');
    }
}
