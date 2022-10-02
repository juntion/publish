<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateOssTempUploads extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('oss_temp_uploads', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->string('object')->default('')->comment('oss对象名(即路径)');
            $table->string('bucket')->default('')->comment('oss桶');
            $table->json('origin_body')->comment('oss回调的原始body信息');

            $table->timestamps();
            $table->unique('object');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('oss_temp_uploads');
    }
}
