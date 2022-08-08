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
        Schema::create('student_pick_up_riders', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('student_pid');
            $table->string('rider_pid');
            $table->string('status')->default(1);
            $table->string('note')->nullable();
            $table->string('school_user_pid')->nullable();
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
        Schema::dropIfExists('student_pick_up_riders');
    }
};
