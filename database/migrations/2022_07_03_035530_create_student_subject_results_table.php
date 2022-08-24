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
        Schema::create('student_subject_results', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('student_pid');
            $table->string('class_param_pid');
            $table->string('pid')->unique()->nullable();
            $table->string('subject_type')->comment('subject type pid');
            $table->float('total')->default(0);
            $table->string('seated')->default(1);
            // $table->string('class_result_pid');
            // $table->string('comment')->nullable();
            // $table->float('min_score')->nullable();
            // $table->float('max_score')->nullable();
            // $table->float('avg_score')->nullable();
            $table->text('teacher_comment')->nullable();
            $table->text('subject_teacher')->nullable();
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
        Schema::dropIfExists('student_subject_results');
    }
};
