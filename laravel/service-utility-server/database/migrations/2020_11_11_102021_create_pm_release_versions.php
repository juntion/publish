<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmReleaseVersions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 发版产品的版本号
        Schema::create('pm_release_versions', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('release_product_id')->comment('发版产品ID');
            $table->foreign('release_product_id')->references('id')->on('pm_release_products')->onDelete('cascade');
            $table->unsignedSmallInteger('main_version')->default(0)->comment('主版本号');
            $table->unsignedSmallInteger('second_version')->default(0)->comment('次版本号');
            $table->unsignedSmallInteger('third_version')->default(0)->comment('末版本号');
            $table->unique(['release_product_id', 'main_version', 'second_version', 'third_version'], 'release_product_version_unique');
            $table->unsignedTinyInteger('status')->default(1)->index()->comment('状态：1：待发布测试，2：版本测试中；3：已发布上线');
            $table->unsignedBigInteger('creator_id')->comment('创建人ID');
            $table->string('creator_name')->comment('创建人名称');
            $table->dateTime('expected_release_test_time')->nullable()->comment('预计发布测试时间');
            $table->unsignedBigInteger('release_test_user_id')->nullable()->comment('发布测试用户ID');
            $table->string('release_test_user_name')->default('')->comment('发布测试用户名称');
            $table->dateTime('release_test_time')->nullable()->comment('实际发布测试时间');
            $table->string('release_test_comment', 500)->default('')->comment('发布测试备注');
            $table->dateTime('expected_release_online_time')->nullable()->comment('预计发布上线时间');
            $table->unsignedBigInteger('release_online_user_id')->nullable()->comment('发布上线用户ID');
            $table->string('release_online_user_name')->default('')->comment('发布上线用户名称');
            $table->dateTime('release_online_time')->nullable()->comment('实际发布上线时间');
            $table->string('release_online_comment', 500)->default('')->comment('发布上线备注');
            $table->unsignedSmallInteger('feature_count')->default(0)->comment('功能点个数');
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
        Schema::dropIfExists('pm_release_versions');
    }
}
