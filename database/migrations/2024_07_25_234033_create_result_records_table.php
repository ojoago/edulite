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
        Schema::create('result_records', function (Blueprint $table) {
            $table->id();
            $table->float('total_students');
            $table->float('fee')->nullable();
            $table->float('discount')->nullable();
            $table->float('amount')->nullable();
            $table->string('term');
            $table->string('session');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->json('classes')->nullable();
            $table->string('school_pid');
            $table->tinyInteger('status')->default(0)->comment('0:not paid, 1:paid, 2 out standing bal, 3 credit, 4 free, 5:Annual Sub');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('result_records');
    }
};
