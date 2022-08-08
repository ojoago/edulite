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
        Schema::create('psycho_grades', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('pid');
            $table->string('grade');
            $table->float('score')->default(0);
            $table->string('status')->default(1)->comment('1 enable,0 disabled');
            $table->string('staff_pid')->comment('creator');
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
        Schema::dropIfExists('psycho_grades');
    }
};
