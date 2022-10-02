<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarTemplatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebar_templates', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('模板名');
            $table->string('comment')->default('')->comment('备注信息');
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
        Schema::dropIfExists('sidebar_templates');
    }
}
