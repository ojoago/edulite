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
        Schema::create('student_awards', function (Blueprint $table) {
            $table->id();
            $table->string('student_pid');
            $table->foreign('student_pid')->references('pid')->on('students');
            $table->string('arm_pid');
            $table->foreign('arm_pid')->references('pid')->on('class_arms');
            $table->string('term_pid');
            $table->foreign('term_pid')->references('pid')->on('terms');
            $table->string('session_pid');
            $table->foreign('session_pid')->references('pid')->on('sessions');
            $table->string('award_pid');
            $table->foreign('award_pid')->references('pid')->on('award_keys');
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
        Schema::dropIfExists('student_awards');
    }
};
