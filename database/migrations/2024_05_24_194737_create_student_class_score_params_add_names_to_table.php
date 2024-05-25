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
        Schema::table('student_class_score_params', function (Blueprint $table) {
            $table->string('arm')->nullable()->comment('arm name');
            $table->string('term')->nullable()->comment('term name');
            $table->string('session')->nullable()->comment('session');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_class_assessment_params');
    }
};
