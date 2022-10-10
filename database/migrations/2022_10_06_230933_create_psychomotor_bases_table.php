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
        Schema::create('psychomotor_bases', function (Blueprint $table) {
            $table->id();
            $table->string('psychomotor');
            $table->integer('obtainable_score')->default(0);
            $table->string('description')->nullable();
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->integer('status')->default(1);
            $table->string('staff_pid');
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
        Schema::dropIfExists('psychomotor_bases');
    }
};
