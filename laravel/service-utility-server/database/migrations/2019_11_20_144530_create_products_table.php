<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // IT产品表
        Schema::create('pm_products', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->default('')->comment('名称');
            $table->unsignedTinyInteger('status')->default(0)->comment('状态；0：关闭；1：开启');
            $table->string('description')->default('')->comment('描述');
            $table->unsignedTinyInteger('type')->default(0)->comment('类型；0：产品线；1：产品；2：模块；3：类别；');
            $table->unsignedBigInteger('parent_id')->default(0)->index()->comment('父级ID');
            $table->unsignedTinyInteger('sort')->default(0)->comment('排序');
            $table->unsignedTinyInteger('design_review')->default(0)->comment('是否需要设计走查；1：需要；');
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
        Schema::dropIfExists('pm_products');
    }
}
