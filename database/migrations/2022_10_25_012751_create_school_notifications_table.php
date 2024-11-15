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
        Schema::create('school_notifications', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('session_pid');
            $table->string('term_pid');
            $table->text('message');
            $table->string('pid')->unique();
            $table->integer('type')->comment('1 notice board, 2 parent, 3 Rider, 4 general, 5 students, 6 all staff, 7 academic staff, 8 non-academic');
            $table->integer('category')->comment('1 notice board, 2 parent, 3 staff, 4 student, 5 all')->nullable();
            $table->string('begin',20)->nullable();
            $table->string('end',20)->nullable();
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
        Schema::dropIfExists('school_notifications');
    }
};
