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
        Schema::create('hostel_portals', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->string('hostel_pid');
            $table->string('portal_pid');
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
        Schema::dropIfExists('hostel_portals');
    }
};
