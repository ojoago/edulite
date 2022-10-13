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
        Schema::create('grade_key_bases', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            // $table->string('grade_pid');
            $table->string('title');
            $table->string('grade');
            $table->float('grade_point')->nullable();
            $table->string('remark')->nullable();
            $table->float('min_score')->default(0);
            $table->float('max_score')->default(0);
            $table->string('color')->nullable();
            $table->string('pid')->unique();
            $table->string('class_pid')->nullable();
            $table->string('arm_pid')->nullable();
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
        Schema::dropIfExists('grade_key_bases');
    }
};
