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
        Schema::create('school_payment_arrangements', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('price');
            $table->integer('module')->default(1)->comment('1: per term/student ,2 per session/student, 3 anuall, 4 one off');
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
        Schema::dropIfExists('school_payment_arrangements');
    }
};
