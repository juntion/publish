<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateKeysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_keys', function (Blueprint $table) {
            $table->char('key')->comment('搜索关键词');
            $table->unsignedInteger('count')->default(0)->comment('搜索次数，最大2147483647');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique('key');
            $table->index('count');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_keys');
    }
}
