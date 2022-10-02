<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubjectsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_subjects', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->string('name')->default('')->comment('专题名称');

            $table->string('object')->comment('专题封面，存储路径，oss的资源路径，oss的对象名');

            $table->unsignedTinyInteger('sort')->default(0)->comment('专题的排序');

            $table->softDeletes();
            $table->timestamps();
        });

        Schema::create('share_subject_to_resources', function (Blueprint $table) {
            $table->char('subject_uuid', 32)->comment('share_subjects.uuid');
            $table->char('resource_uuid', 32)->comment('share_resources.uuid');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['subject_uuid', 'resource_uuid']);
            $table->foreign('subject_uuid')->references('uuid')->on('share_subjects')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('resource_uuid')->references('uuid')->on('share_resources')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_subject_to_resources');
        Schema::dropIfExists('share_subjects');
    }
}
