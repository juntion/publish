<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUserHasSidebarTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_has_sidebar_templates', function (Blueprint $table) {
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('sidebar_template_id');
            $table->foreign('sidebar_template_id')->references('id')->on('sidebar_templates')->onDelete('cascade');
            $table->unsignedTinyInteger('is_manager')->default(0)->comment('是否该模板管理员；0：否；1：是；');
            $table->primary(['user_id', 'sidebar_template_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_has_sidebar_templates');
    }
}
