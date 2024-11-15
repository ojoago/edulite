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
        Schema::create('affective_domains', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->float('max_score')->default(0);
            $table->string('status')->default(1);
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
        Schema::dropIfExists('effective_domains');
    }
};
