<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OpenAuth extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('open_auth', function (Blueprint $table) {
            $table->char('access_key_id', 32)->comment('授权ID')->primary();
            $table->char('access_key_secret', 20)->comment('授权秘钥')->index();
            $table->unsignedInteger('exp_time')->comment('过期时间(时间戳)');
            $table->string('remarks')->comment('备注信息');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态，0正常，1禁用');
        
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
        Schema::dropIfExists('open_auth');
    }
}
