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
        Schema::create('student_classes', function (Blueprint $table) {
            $table->id();
            $table->string('student_pid');
            $table->string('school_category')->comment('category id');
            $table->string('session')->comment('academic session');
            $table->string('school_class')->comment('');
            $table->string('current_class')->comment('class arm');
            $table->string('next_class');
            $table->string('previous_class');
            $table->string('school_pid')->nullable();
            $table->string('date',20)->nullable();
            $table->string('pid')->unique();
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
