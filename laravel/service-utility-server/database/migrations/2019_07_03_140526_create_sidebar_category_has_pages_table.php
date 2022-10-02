<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSidebarCategoryHasPagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sidebar_category_has_pages', function (Blueprint $table) {
            $table->unsignedBigInteger('sidebar_category_id');
            $table->foreign('sidebar_category_id')->references('id')->on('sidebar_categories')->onDelete('cascade');
            $table->unsignedBigInteger('page_id');
            $table->foreign('page_id')->references('id')->on('pages')->onDelete('cascade');
            $table->integer('sort')->default(0)->comment('排序');
            $table->primary(['sidebar_category_id', 'page_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('sidebar_category_has_pages');
    }
}
