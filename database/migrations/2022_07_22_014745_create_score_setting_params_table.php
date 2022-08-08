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
        Schema::create('score_setting_params', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->comment('school pid');
            $table->string('staff_pid')->comment('creator');
            $table->string('status')->default(1)->comment('1 enabled, 2 disabled');
            $table->string('category_pid')->nullable();
            $table->string('class_pid')->comment('class pid');
            $table->string('session_pid')->comment('school session pid');
            $table->string('term_pid')->comment('term pid');
            $table->string('pid')->unique();
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
        Schema::dropIfExists('score_setting_data');
    }
};
