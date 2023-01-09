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
        Schema::create('seasonal_messages', function (Blueprint $table) {
            $table->id();
            $table->string('message');
            $table->string('message_time')->comment('month and day');
            $table->integer('message_type')->nullable()->comment('1 big sallah, 2 small sallah, 3 xmas, 4 new year , 5 new term,6 new session');
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
        Schema::dropIfExists('seasonal_messages');
    }
};
