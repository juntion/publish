<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWorkSchedulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('work_schedules', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->date('date')->comment('日期')->index();
            $table->unsignedTinyInteger('type')->comment('班次类型；1：标准班次；2：半天班次；3：公休或节假日');
            $table->decimal('workload', 2,1)->comment('工作量（天）；默认值，标准班次：1；半天班次：0.5；休息日：0；');
            $table->decimal('working_hours', 2,1)->comment('工时（小时）；默认值，标准班次：7.5；半天班次：2.5；休息日：0；');
            $table->time('morning_to_work')->nullable()->default(null)->comment('上午上班时间；标准班次/半天班次：9:30:00；');
            $table->time('morning_off_work')->nullable()->default(null)->comment('上午下班时间；标准班次：12:30:00；半天班次：12:00:00');
            $table->time('noon_to_work')->nullable()->default(null)->comment('中午上班时间；标准班次：14:00:00；');
            $table->time('noon_off_work')->nullable()->default(null)->comment('中午下班时间；标准班次：18:30:00；');
            $table->unsignedBigInteger('updated_user_id')->nullable()->default(null)->comment('更新人ID')->index();
            $table->string('updated_user_name')->default('')->comment('更新人名称');
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
        Schema::dropIfExists('work_schedules');
    }
}
