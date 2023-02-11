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
        Schema::create('active_admissions', function (Blueprint $table) {
            $table->id();
            $table->string('admission_pid');
            $table->string('admission_pid')->references('pid')->on(' admission_details');
            $table->string('school_pid');
            $table->foreign('school_pid')->references('pid')->on('schools');
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
        Schema::dropIfExists('active_admissions');
    }
};
