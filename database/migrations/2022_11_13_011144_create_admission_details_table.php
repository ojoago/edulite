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
        Schema::create('admission_details', function (Blueprint $table) {
            $table->id();
            $table->string('from',20);
            $table->string('to',20);
            $table->string('session_pid');
            $table->string('pid')->unique();
            $table->string('creator')->comment('creator');
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
        Schema::dropIfExists('admission_infos');
    }
};
