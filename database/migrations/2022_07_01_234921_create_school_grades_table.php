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
        Schema::create('school_grades', function (Blueprint $table) {// grade params
            $table->id();
            $table->string('school_pid');
            $table->string('category_pid'); //school category
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('class_pid')->nullable();
            $table->string('pid')->unique();
            $table->string('class_arm_pid')->nullable();
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
        Schema::dropIfExists('school_grades');
    }
};
