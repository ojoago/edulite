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
        Schema::create('active_term_details', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('begin', 20)->nullable();
            $table->string('end', 20)->nullable();
            $table->text('note')->nullable();
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
        Schema::dropIfExists('active_terms_details');
    }
};
