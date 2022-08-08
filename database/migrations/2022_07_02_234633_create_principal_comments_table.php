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
    //principal defined comments
    public function up()
    {
        Schema::create('principal_comments', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->float('min');
            $table->float('max');
            $table->float('comment');
            $table->string('staff_pid')->comment('principal pid');
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
        Schema::dropIfExists('principal_comments');
    }
};
