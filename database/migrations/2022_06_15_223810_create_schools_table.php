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
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('pid')->unique();
            $table->string('organisation_id')->nullable();
            $table->string('school_name');
            $table->string('school_contact')->nullable();
            $table->string('school_address');
            $table->string('school_moto')->nullable();
            $table->string('school_logo')->nullable();
            $table->string('school_website')->nullable();
            // $table->string('school_theme')->nullable();
            $table->string('school_handle')->nullable();
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
        Schema::dropIfExists('schools');
    }
};
