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
        Schema::create('staff_attendance_configs', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('clock_in_begin');
            $table->string('clock_in_end');
            $table->string('late_time');
            $table->string('office_resume_time');
            $table->string('office_close_time');
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('fence_radius')->nullable();
            $table->longText('note')->nullable();
            $table->string('created_by')->nullable();
            $table->string('area')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('staff_attendance_configs');
    }
};
