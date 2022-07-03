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
        Schema::create('student_assesments', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('teacher_pid');
            $table->string('subject_pid');
            $table->string('subject_cat_pid')->nullable();
            $table->string('category_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('class_pid')->nullable();
            $table->string('class_arm_pid');
            $table->integer('status')->default(1)->comment('0 locked, 1 open');
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
        Schema::dropIfExists('student_assesments');
    }
};
