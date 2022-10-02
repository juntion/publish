<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugsAccept extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bugs_accept', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bug_id')->index();
            $table->unsignedBigInteger('user_id')->default(0)->comment('验收人ID');
            $table->string('user_name')->default('')->comment('验收人名称');
            $table->unsignedTinyInteger('type')->comment('验收人类型：1：发布人；2：测试负责人；3：产品负责人');
            $table->unsignedTinyInteger('result')->comment('验收结果：1：合格；0：不合格');
            $table->string('comment')->nullable()->comment('备注');
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
        Schema::dropIfExists('pm_bugs_accept');
    }
}
