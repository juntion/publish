<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRouteTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('routes', function (Blueprint $table) {
            $table->comment = '入口信息表';

            $table->char('uuid', 32)->primary()->comment('入口的uuid,和权限的permission_uuid 值一样,一个入口就是一个访问权限，uuid一样');
            $table->string('guard_name');
            $table->unsignedTinyInteger('type')->comment('入口类型，对应权限的类型，2，普通入口，3首页入口')->default(2);
            $table->string('route', 255)->default('')->comment('入口的路由链接，前端的路由');
            $table->string('name', 255)->default('')->comment('入口的标识，唯一,和前端的路由名称一样');
            $table->json('locale')->nullable()->default(null)->comment('国际化，{"en-US":"home","zh-CN":"首页"}');
            $table->string('comment', 255)->default('')->comment('入口的备注信息');
            $table->timestamps();

            $table->unique(['name','guard_name']);
            $table->foreign('uuid')->references('uuid')->on('permissions')->onDelete('cascade')->onUpdate('cascade');
        });

        Schema::create('route_menus', function (Blueprint $table) {
            $table->comment = '入口分类信息表';

            $table->char('uuid', 32)->primary();
            $table->char('parent_uuid', 32)->nullable()->default(null)->index();
            $table->string('guard_name');
            $table->string('name', 255)->default('')->comment('访问入口分类标识名称，唯一');
            $table->unsignedTinyInteger('sort')->default(0)->comment('侧边栏排序');
            $table->string('icon', 255)->default('')->comment('分类的图标');
            $table->string('comment', 255)->default('')->comment('分类的备注信息');
            $table->json('locale')->nullable()->default(null)->comment('国际化 {"en-US":"Order process tracking","zh-CN":"订单流程跟踪"}');
            $table->timestamps();

            $table->unique(['name','guard_name']);
        });

        Schema::create('route_to_menus', function (Blueprint $table) {
            $table->comment = '入口分类与入口关联关系表';

            $table->char('route_uuid', 32);
            $table->char('route_menu_uuid', 32);
            $table->unsignedTinyInteger('sort')->default(0)->comment('入口在分类中的排序');
            $table->timestamp('created_at')->nullable()->useCurrent();

            $table->unique(['route_menu_uuid','route_uuid']);
            $table->foreign('route_uuid')->references('uuid')->on('routes')->onDelete('cascade')->onUpdate('cascade');
            $table->foreign('route_menu_uuid')->references('uuid')->on('route_menus')->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('route_to_menus');
        Schema::dropIfExists('route_menus');
        Schema::dropIfExists('routes');
    }
}
