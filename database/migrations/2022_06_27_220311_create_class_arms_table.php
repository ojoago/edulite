<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('class_arms', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('class_pid');
            $table->string('pid')->unique();
            $table->string('arm');
            $table->string('arm_number');
            $table->string('staff_pid')->comment('creator');
            $table->string('status')->default(1)->comment('1 enabled, 0 disabled');
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
        Schema::dropIfExists('class_arms');
    }
};
