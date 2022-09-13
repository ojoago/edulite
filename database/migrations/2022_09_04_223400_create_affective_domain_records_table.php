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
        Schema::create('affective_domain_records', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('student_pid');
            $table->string('key_pid');
            $table->string('class_param_pid');
            $table->float('score');
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
        Schema::dropIfExists('affective_domain_records');
    }
};
