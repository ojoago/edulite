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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('bank_pid');
            $table->string('pid')->unique();
            $table->longText('question')->nullable();
            $table->string('path')->nullable();
            $table->float('mark')->nullable();
            $table->tinyInteger('type')->comment('1:radio,2:check');
            $table->json('options')->nullable();
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
        Schema::dropIfExists('questions');
    }
};
