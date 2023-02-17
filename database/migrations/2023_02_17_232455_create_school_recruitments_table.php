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
        Schema::create('school_recruitments', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->foreign('school_pid')->references('pid')->on('schools');
            $table->string('pid')->unique();
            $table->string('qualification')->nullable();
            $table->string('course')->nullable();
            $table->text('note')->nullable();
            $table->string('years')->nullable();
            $table->integer('status')->default(1);
            $table->text('subjects')->nullable();
            $table->string('end_date',20)->nullable();
            $table->string('start_date',20)->nullable();
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
        Schema::dropIfExists('school_recruitments');
    }
};
