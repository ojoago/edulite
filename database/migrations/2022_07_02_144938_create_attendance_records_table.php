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
        Schema::create('attendance_records', function (Blueprint $table) {//attendance histories
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('attendance_pid')->nullable();//selected attendance eg jss 1 a attendance
            $table->string('staff_pid')->comment('attendance taken by');
            $table->string('date', 20);
            $table->string('note')->nullable()->comment('comments');
            $table->string('pid')->unique();
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
