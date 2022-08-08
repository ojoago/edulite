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
        Schema::create('student_classes', function (Blueprint $table) {//class 
            $table->id();
            $table->string('student_pid');
            // $table->string('category_pid')->comment('category id')->nullable();
            $table->string('session_pid')->comment('academic session');
            // $table->string('school_class')->comment('');
            $table->string('arm_pid')->comment('class arm');
            // $table->string('next_class');
            // $table->string('previous_class');
            $table->string('school_pid');
            $table->string('date',20)->nullable();
            $table->string('pid')->unique();
            $table->string('staff_pid')->comment('creator');
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
        Schema::dropIfExists('student_c_lasses');
    }
};
