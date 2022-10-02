<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugsHasLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bugs_has_labels', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('bug_id')->index();
            $table->foreign('bug_id')->references('id')->on('pm_bugs')->onDelete('cascade');
            $table->string('name')->comment('标签名称');
            $table->unsignedBigInteger('user_id')->default(0)->comment('操作人ID');
            $table->string('user_name')->default('')->comment('操作人名称');
            $table->string('comment')->nullable()->comment('备注');
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
        Schema::dropIfExists('pm_bugs_has_labels');
    }
}
