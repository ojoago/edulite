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
        Schema::create('student_class_result_params', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('session_pid')->nullable();
            $table->string('term_pid')->nullable();
            $table->string('arm_pid')->nullable();
            $table->string('class_param_pid');
            $table->string('pid')->unique();
            $table->string('principal_pid')->nullable();
            $table->string('class_teacher_pid')->nullable();
            $table->string('portal_pid')->nullable();
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
        Schema::dropIfExists('student_class_result_params');
    }
};
