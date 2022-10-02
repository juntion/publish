<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePmAppealsHasLabels extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // 诉求拥有的标签
        Schema::create('pm_appeals_has_labels', function (Blueprint $table) {
            $table->unsignedBigInteger('appeal_id')->comment('诉求ID');
            $table->foreign('appeal_id')->references('id')->on('pm_appeals')->onDelete('cascade');
            $table->unsignedBigInteger('label_id')->comment('标签ID');
            $table->foreign('label_id')->references('id')->on('pm_labels')->onDelete('cascade');
            $table->primary(['appeal_id', 'label_id']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('pm_appeals_has_labels');
    }
}
