<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->char('uuid', 32)->primary();
            $table->char('group_uuid', 32)->nullable()->comment('组uuid,admin_groups.uuid');
            $table->string('name')->unique();
            $table->string('email')->nullable()->default(null)->unique();
            $table->string('avatar')->default('');
            $table->string('password')->nullable()->default(null);
            $table->timestamps();

            $table->unsignedInteger('id')->nullable()->default(null)->unique()->comment('废弃，保留以兼容原数据，对应 erp的admin.admin_id，对应uums的users.origin_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
