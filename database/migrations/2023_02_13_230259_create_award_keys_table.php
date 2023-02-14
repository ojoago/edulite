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
        Schema::create('award_keys', function (Blueprint $table) {
            $table->id();
            $table->string('award');
            $table->string('pid')->unique();
            $table->string('school_pid');
            $table->foreign('school_pid')->references('pid')->on('schools');
            $table->integer('status')->default(1);
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
        Schema::dropIfExists('award_keys');
    }
};
