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
        Schema::create('school_parents', function (Blueprint $table) {
            $table->id();
            $table->string('user_pid');
            $table->text('school_pid');
            $table->string('pid')->unique();
            $table->string('role')->nullable()->default(650);
            $table->text('passport')->nullable();
            $table->text('status')->nullable()->default(1);
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
        Schema::dropIfExists('parents');
    }
};
