<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugHasHandler extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bugs_has_handler', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bug_id');
            $table->foreign('bug_id')->references('id')->on('pm_bugs')->onDelete('cascade');
            $table->unsignedBigInteger('handler_id')->default(0)->comment('跟进人ID');
            $table->string('handler_name')->default('')->comment('跟进人名称');
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
        Schema::dropIfExists('pm_bugs_has_handler');
    }
}
