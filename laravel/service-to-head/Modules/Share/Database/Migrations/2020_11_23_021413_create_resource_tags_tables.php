<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateResourceTagsTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_resource_tags', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->string('name')->default('')->comment('标签名, 唯一');
            $table->char('creator_uuid', 32)->comment('创建人,admins.uuid');

            $table->unique('name');
            $table->index('creator_uuid');

            $table->softDeletes();
            $table->timestamp('created_at')->nullable()->useCurrent();
            $table->index('created_at');
        });

        Schema::create('share_resources_to_tags', function (Blueprint $table) {
            $table->char('resource_uuid', 32)->comment('share_resources.uuid');
            $table->char('tag_uuid', 32)->comment('share_resource_tags.uuid');

            $table->char('admin_uuid', 32)->comment('设定此标签的人,admins.uuid');
            $table->char('admin_name', 32)->comment('设定此标签的人名,admins.name');

            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['resource_uuid', 'tag_uuid']);
            $table->foreign('resource_uuid')->references('uuid')->on('share_resources')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreign('tag_uuid')->references('uuid')->on('share_resource_tags')->cascadeOnDelete()->cascadeOnUpdate();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_resources_to_tags');
        Schema::dropIfExists('share_resource_tags');
    }
}
