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
        Schema::create('cumulative_results', function (Blueprint $table) {
            $table->id();
            $table->string('pid')->unique();
            $table->string('session_pid');
            $table->string('arm_pid');
            $table->string('student_pid');
            $table->string('school_pid');
            $table->string('principal_comment')->nullable();
            $table->string('teacher_comment')->nullable();
            $table->string('portal_comment')->nullable();
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
        Schema::dropIfExists('cumulative_results');
    }
};
