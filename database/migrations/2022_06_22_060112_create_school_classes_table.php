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
        Schema::create('school_classes', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            // $table->string('category_pid');
            // $table->string('class_pid');
            $table->string('arm_pid');
            $table->string('pid')->unique();
            $table->string('status')->default(1)->comment('1 enabled, 0 diabled');
            $table->string('staff_pid')->nullable()->comment('creator');
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
        Schema::dropIfExists('school_classes');
    }
};
