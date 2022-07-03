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
            $table->string('reg_number');
            $table->string('user_pid');
            $table->string('pid')->unique()->comment('student unique Id');
            $table->integer('type')->default(1)->comment('1 day, 2 boarding');
            $table->string('school_pid');
            $table->string('status')->default(1)->comment('0 = disabled, 1 = active student, 2 = graduated, 3 = left the school');
            $table->text('student_image_path');
            $table->text('address')->nullable();
            $table->string('date',20)->nullable();
            $table->string('religion')->nullable();
            $table->text('title')->nullable();
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
