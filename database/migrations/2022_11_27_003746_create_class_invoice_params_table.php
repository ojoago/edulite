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
        Schema::create('class_invoice_params', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('arm_pid');
            $table->string('pid')->unique();
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
        Schema::dropIfExists('class_invoice_params');
    }
};
