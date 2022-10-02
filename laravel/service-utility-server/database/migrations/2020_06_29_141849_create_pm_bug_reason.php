<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmBugReason extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pm_bug_reason', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('reason')->comment('原因类型');
            $table->unsignedTinyInteger('required_analyse')->default(0)->comment('分析说明是否必填 0：非必填；1：必填');
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
        Schema::dropIfExists('pm_bug_reason');
    }
}
