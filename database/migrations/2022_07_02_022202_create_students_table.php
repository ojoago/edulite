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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('pid')->unique()->comment('student unique Id');
            $table->string('user_pid');
            $table->string('reg_number');
            $table->string('fullname')->nullable();
            $table->string('parent_pid')->nullable();
            $table->integer('type')->default(1)->comment('1 day, 2 boarding');
            $table->string('school_pid');
            $table->string('status')->default(1)->comment('0 = disabled, 1 = active student, 2 = graduated, 3 = left the school, 4 = suspended');
            $table->string('admitted_session_pid')->nullable();
            $table->string('admitted_class')->nullable();
            $table->string('admitted_term')->nullable();
            $table->string('current_class_pid')->nullable();
            $table->string('current_session_pid')->nullable();
            $table->text('passport')->nullable();
            $table->text('address')->nullable();
            $table->string('session_pid');
            $table->string('religion')->nullable();
            $table->string('title')->nullable()->default('student');
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
        Schema::dropIfExists('students');
    }
};
