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
        Schema::create('attendance_takens', function (Blueprint $table) {//attendance histories
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('class_attendance_pid');
            $table->string('staff_pid')->comment('attendance taken by');
            $table->string('date', 20)->nullable();
            $table->integer('note')->comment('comments');
            $table->integer('pid')->unique();
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
        Schema::dropIfExists('attendance_takens');
    }
};
