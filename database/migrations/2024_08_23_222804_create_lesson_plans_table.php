<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('lesson_plans', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('category_pid');
            $table->string('class_pid');
            $table->string('arm_pid');
            $table->string('subject_pid');
            $table->string('staff_pid')->nullable();
            $table->string('week',20);
            $table->string('period',20);
            $table->string('date',20);
            $table->tinyInteger('type')->comment('1:file,2:text');
            $table->tinyInteger('status')->comment('1:aproved,0:pending:2:reject')->default(0);
            $table->string('path')->nullable();
            $table->longText('plan')->nullable();

            $table->timestamps();
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lesson_plans');
    }
};
