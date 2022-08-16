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
        Schema::create('staff_subjects', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('arm_subject_pid')->comment('the subject assigned to class arm pid ');//the assigned to class arm
            $table->string('teacher_pid')->comment('teacher pid (staff)');
            $table->string('staff_pid')->comment('creator');
            $table->string('pid')->unique();
            // $table->string('category_pid');
            // $table->string('subject_pid');
            // $table->string('arm_pid');
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
        Schema::dropIfExists('staff_subjects');
    }
};
