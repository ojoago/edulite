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
        Schema::create('score_setting_bases', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('class_pid')->nullable();
            $table->string('arm_pid')->nullable();
            $table->string('pid')->unique();
            $table->float('score'); //max score
            $table->string('assessment_title_pid'); //
            $table->integer('type')->default(1)->comment('1 part of student result, 2 mid term');
            $table->integer('order');
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
        Schema::dropIfExists('score_setting_bases');
    }
};
