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
        Schema::create('question_answers', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('student_pid');
            $table->string('question_pid');
            $table->longText('answer')->nullable();
            $table->longText('remark')->nullable();
            $table->float('mark')->nullable();
            $table->tinyInteger('status')->default(0)->comment('0:submitted, 1:marked');
            $table->string('path')->nullable();
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
        Schema::dropIfExists('question_answers');
    }
};
