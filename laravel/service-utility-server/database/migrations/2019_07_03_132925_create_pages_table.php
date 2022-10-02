<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pages', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('入口名');
            $table->string('comment')->default('')->comment('备注信息');
            $table->json('locale')->nullable()->comment('多语言');
            $table->string('guard_name')->default('')->comment('看守器');
            $table->string('route')->default('')->comment('前端路由');
            $table->string('route_name')->default('')->comment('前端路由名');
            $table->unsignedTinyInteger('type')->default(0)->comment('页面类型；0：普通页面；1：首页；');
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
        Schema::dropIfExists('pages');
    }
}
