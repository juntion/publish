<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubsystemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsystems', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('系统名称');
            $table->string('link')->comment('链接');
            $table->unsignedTinyInteger('sidebar')->default(0)->comment('是否设置侧边栏；0，否；1：是；');
            $table->unsignedTinyInteger('homepage')->default(0)->comment('是否设置首页；0：否；1：是；');
            $table->json('locale')->nullable()->comment('多语言');
            $table->string('guard_name')->default('')->comment('看守器');
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
        Schema::dropIfExists('subsystems');
    }
}
