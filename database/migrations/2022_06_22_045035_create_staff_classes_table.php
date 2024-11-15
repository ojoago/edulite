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
        Schema::create('staff_classes', function (Blueprint $table) {
            $table->id();
            $table->string('teacher_pid');
            $table->string('arm_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            // $table->string('date', 20);
            $table->string('pid')->nullable();
            $table->string('school_pid');
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
        Schema::dropIfExists('staff_classes');
    }
};
