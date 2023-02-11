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
        Schema::create('swap_class_histories', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->foreign('school_pid')->references('pid')->on('schools');
            $table->string('student_pid');
            $table->foreign('student_pid')->references('pid')->on('students');
            $table->string('new_class');
            $table->string('previus_class');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('created_by');
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
        Schema::dropIfExists('swap_class_histories');
    }
};
