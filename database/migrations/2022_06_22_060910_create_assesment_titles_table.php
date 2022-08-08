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
        Schema::create('assesment_titles', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('title');
            $table->string('category')->nullable();
            $table->string('description')->nullable();
            $table->string('pid')->unique();
            $table->string('status')->default(1)->comment('1 enabled, 0 disabled');
            $table->string('staff_pid')->comment('creator');
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
        Schema::dropIfExists('assesment_titles');
    }
};
