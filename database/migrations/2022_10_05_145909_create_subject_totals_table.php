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
        Schema::create('subject_totals', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('student_pid');
            $table->string('class_param_pid');
            $table->string('pid')->unique()->nullable();
            $table->string('subject_pid')->comment('subject pid');
            $table->string('subject_type')->comment('subject type pid');
            $table->float('total')->default(0);
            $table->string('seated')->default(1);
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
        Schema::dropIfExists('subject_totals');
    }
};
