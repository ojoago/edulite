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
        Schema::create('student_score_sheets', function (Blueprint $table) {
            $table->id();
            $table->string('assessment_pid'); //this need to be changed
            $table->string('student_pid');
            $table->string('ca_type_pid');
            $table->string('score');
            $table->string('school_pid')->nullable();
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
        Schema::dropIfExists('student_assesment_records');
    }
};
