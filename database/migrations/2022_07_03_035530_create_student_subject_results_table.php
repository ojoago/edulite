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
        Schema::create('student_subject_results', function (Blueprint $table) {
            $table->id();
            $table->string('student_pid');
            $table->string('assessment_pid');
            $table->string('comment')->nullable();
            $table->string('position')->nullable();
            $table->float('total_score')->nullable();
            $table->float('min_score')->nullable();
            $table->float('max_score')->nullable();
            $table->float('avg_score')->nullable();
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
        Schema::dropIfExists('student_subject_results');
    }
};
