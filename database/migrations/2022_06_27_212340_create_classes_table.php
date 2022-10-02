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
        Schema::create('classes', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('category_pid');
            $table->string('pid')->unique();
            $table->string('class');
            $table->string('staff_pid')->comment('creator');
            $table->string('status')->default(1)->comment('1 enabled, 0 disabled');
            $table->string('class_number');//->comment('1 enabled, 0 disabled');
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
        Schema::dropIfExists('classes');
    }
};
