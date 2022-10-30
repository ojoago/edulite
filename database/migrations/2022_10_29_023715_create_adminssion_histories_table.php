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
        Schema::create('adminssion_histories', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('admission_number');
            $table->string('student_pid');
            $table->string('category_pid')->nullable();
            $table->string('class_pid')->nullable();
            $table->string('arm_pid')->nullable();
            $table->string('admitted_arm_pid')->nullable();
            $table->string('session_pid')->nullable();
            $table->string('term_pid')->nullable();
            $table->string('staff_pid')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_gsm')->nullable();
            $table->string('contact_email')->nullable();
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
        Schema::dropIfExists('adminssion_histories');
    }
};
