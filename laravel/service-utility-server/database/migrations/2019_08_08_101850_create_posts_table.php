<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePostsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('number')->default('')->comment('岗位编号,eg: G0001'); // 固定唯一标识，可以为空，方便程序判断
            $table->string('name')->comment('岗位名称');
            $table->string('comment')->comment('备注');
            $table->json('locale')->comment('多语言');
            $table->unsignedBigInteger('position_id')->comment('职位id');
            $table->foreign('position_id')->references('id')->on('positions')->onDelete('cascade');
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
        Schema::dropIfExists('posts');
    }
}
