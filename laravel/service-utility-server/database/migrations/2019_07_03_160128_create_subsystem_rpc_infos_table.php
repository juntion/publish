<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSubsystemRpcInfosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('subsystem_rpc_infos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('subsystem_id')->comment('子系统id');
            $table->foreign('subsystem_id')->references('id')->on('subsystems')->onDelete('cascade');
            $table->string('guard_name')->comment('子系统看守器');
            $table->string('rpc_address')->comment('rpc服务地址');
            $table->string('rpc_username')->comment('rpc用户名');
            $table->string('rpc_password')->comment('rpc密码');
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
        Schema::dropIfExists('subsystem_rpc_infos');
    }
}
