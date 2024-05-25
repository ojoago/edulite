<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::rename('student_score_params', 'subject_score_params');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::rename('subject_score_params', 'student_score_params');

    }
};
