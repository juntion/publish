<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTagDataTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tag_data', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->bigInteger('number')->unique()->comment('标签编号');
            $table->string('name', 255)->index();
            $table->char('parent_uuid', 32)->nullable()->default(null)->comment('父级ID');
            $table->string('path', 330)->index()->comment('所有父级UUID');
            $table->tinyInteger('level')->comment('级别');
            $table->tinyInteger('status')->default(1)->comment('状态；1：开启；2：禁用；默认1；');
            $table->json('locale')->nullable()->default(null)->comment('多语言 {"en":"英语","ru":"俄语"}');
            $table->unsignedTinyInteger('type')->index()->comment('标签类型：1：产品标签；2：话题标签');
            $table->string('url_name')->default('')->comment('标签URL名称');
            $table->timestamps();
        });

        /*Schema::create('tag_data_locale', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('tag_data_uuid', 32)->comment('标签数据UUID');
            $table->string('name', 255)->comment('标签名称');
            $table->string('code', 5)->comment('语种代码');

            $table->timestamps();
        });*/

        Schema::create('tag_data_source', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('tag_data_uuid', 32)->index()->comment('标签数据UUID');
            $table->string('model_id', 32)->comment('数据源唯一ID');
            $table->string('model_type', 500)->comment('数据源类型');
            $table->index(['model_type', 'model_id']);
            $table->string('model_desc', 500)->comment('数据描述');
            $table->tinyInteger('priority')->comment('数据优先级');
            $table->tinyInteger('status')->default(1)->comment('状态；1：开启；2：禁用；默认1；');
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
        Schema::dropIfExists('tag_data');
        /*Schema::dropIfExists('tag_data_locale');*/
        Schema::dropIfExists('tag_data_source');
    }
}
