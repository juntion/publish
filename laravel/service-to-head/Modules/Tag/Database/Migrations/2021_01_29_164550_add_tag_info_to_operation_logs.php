<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddTagInfoToOperationLogs extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tag_operation_logs', function (Blueprint $table) {
            $table->bigInteger('tag_number')->default(0)->after('tag_data_uuid')->index()->comment('标签编号');
            $table->string('tag_name', 255)->default('')->after('tag_number')->comment('标签名称');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tag_operation_logs', function (Blueprint $table) {
            $table->dropColumn(['tag_number', 'tag_name']);
        });
    }
}
