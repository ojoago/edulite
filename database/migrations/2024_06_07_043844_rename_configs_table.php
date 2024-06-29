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
        Schema::rename('configs', 'result_configs');
        Schema::table('result_configs', function (Blueprint $table) {
            $table->string('school_pid');
            $table->foreign('school_pid')->references('pid')->on('schools')->onDelete('cascade');
            $table->string('category_pid');
            $table->foreign('category_pid')->references('pid')->on('categories')->onDelete('cascade');
            $table->string('class_teacher')->default('Class Teacher')->nullable();
            $table->string('head_teacher')->default('Principal/Head Teacher')->nullable();
            $table->string('chart')->default('column')->nullable();
            $table->string('title')->default('Continuous Assessment Report')->nullable();
            $table->string('template')->default('default')->nullable();
            $table->tinyInteger('grading')->default(1)->comment('1:position, 2:average, 3:cgpa, 4:none')->nullable();
            $table->tinyInteger('subject_position')->default(0)->nullable();
            $table->tinyInteger('subject_teacher')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_configs');
    }
};
