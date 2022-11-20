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
        Schema::create('fee_item_amounts', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('config_pid');
            $table->float('amount');
            $table->string('arm_pid');
            $table->string('pid')->unique();
            $table->string('term_pid')->nullable();
            $table->string('session_pid')->nullable();
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
        Schema::dropIfExists('fee_item_amounts');
    }
};
