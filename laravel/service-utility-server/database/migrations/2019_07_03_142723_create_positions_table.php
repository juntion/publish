<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePositionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 职称数据
        Schema::create('positions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->default('')->comment('职称编号,eg: J0001'); // 固定唯一标识，可以为空，方便程序判断
            $table->string('name')->comment('职称');
            $table->string('comment')->default('')->comment('备注信息');
            $table->unsignedTinyInteger('is_system')->default(0)->comment('系统职称，不允许删除');
            $table->json('locale')->nullable()->comment('多语言');
            $table->unsignedTinyInteger('type')->nullable()->comment('职位类别: 1-客服，2-销售');
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
        Schema::dropIfExists('positions');
    }
}
