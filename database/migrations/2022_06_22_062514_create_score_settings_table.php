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
        Schema::create('score_settings', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->string('session_pid');
            $table->string('class_arm_pid');// class arm i.e jss 1 a or b or c
            $table->string('term_pid');//1st,2nd, 3rd term
            $table->float('score');//max score
            $table->string('assessment_title_pid');//
            $table->integer('type')->default(1)->comment('1 part of student result, 2 mid term');
            $table->integer('order');
            $table->string('status')->default(1)->comment('1 enabled, 2 disabled');
            $table->string('class_pid')->nullable();
            $table->string('category_pid')->nullable();
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
        Schema::dropIfExists('score_settings');
    }
};
