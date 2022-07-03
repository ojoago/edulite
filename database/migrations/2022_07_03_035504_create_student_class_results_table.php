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
        Schema::create('student_class_results', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('student_pid');
            $table->string('assessment_pid');
            $table->string('class_teacher_comment')->nullable();
            $table->string('principal_comment')->nullable();
            $table->string('class_position')->nullable();
            $table->string('house_master_comment')->nullable();
            $table->float('total_score')->nullable();
            $table->float('min_score')->nullable();//not necessary|agrigate func
            $table->float('max_score')->nullable();//not necessary|agrigate func
            $table->float('avg_score')->nullable();//not necessary|agrigate func
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
        Schema::dropIfExists('student_class_results');
    }
};
