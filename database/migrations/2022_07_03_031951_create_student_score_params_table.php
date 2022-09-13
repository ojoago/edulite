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
        Schema::create('student_score_params', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('class_param_pid');
            $table->string('subject_pid');
            $table->string('subject_type')->nullable();
            $table->string('pid')->unique();
            $table->string('subject_teacher')->nullable();
            $table->string('staff_pid')->nullable()->comment('recorded by');
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
        Schema::dropIfExists('student_assesments');
    }
};
