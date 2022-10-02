<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserAttentionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 用户关注
        Schema::create('pm_user_attentions', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id')->default(0)->comment('用户ID');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('user_name')->default('')->comment('用户名称');
            $table->unsignedBigInteger('model_id')->comment('模型ID');
            $table->string('model_type')->comment('多态模型');
            $table->unsignedBigInteger('dept_id')->default(0)->index()->comment('部门ID');
            $table->string('dept_name')->default('')->comment('部门名称');
            $table->timestamp('created_at')->useCurrent();
            $table->primary(['user_id', 'model_id', 'model_type']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_user_attentions');
    }
}
