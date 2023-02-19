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
        Schema::create('school_job_applieds', function (Blueprint $table) {
            $table->id();
            $table->string('job_pid');
            $table->foreign('job_pid')->references('pid')->on('school_adverts');
            $table->string('user_pid');
            $table->foreign('user_pid')->references('pid')->on('users');
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
        Schema::dropIfExists('school_job_applieds');
    }
};
