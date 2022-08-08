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
        Schema::create('student_class_hystories', function (Blueprint $table) {// class hystories
            $table->id();
            $table->string('session_pid');
            $table->string('arm_pid');
            $table->string('pid');
            $table->integer('class')->comment('class representation 1,2,3...');
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
        Schema::dropIfExists('student_class');
    }
};
