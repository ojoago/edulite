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
        Schema::create('staff_role_histories', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('term_pid')->nullable();
            $table->string('session_pid')->nullable();
            $table->string('role');
            $table->string('staff_pid');
            $table->string('creator')->nullable();
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
        Schema::dropIfExists('staff_role_histories');
    }
};
