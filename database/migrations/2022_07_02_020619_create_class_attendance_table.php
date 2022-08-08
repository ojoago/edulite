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
        Schema::create('class_attendances', function (Blueprint $table) {
            $table->id();
            $table->string('attendance_pid');//attendance type
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->string('name')->nullable();
            $table->string('term_pid');
            $table->string('session_pid');
            $table->string('category_pid')->nullable();
            $table->string('class_pid')->nullable();
            $table->string('arm_pid');
            $table->string('staff_pid')->comment('creator');
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
        Schema::dropIfExists('attendance_details');
    }
};
