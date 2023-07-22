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
        Schema::create('question_banks', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('class_param_pid')->nullable();
            $table->string('pid')->unique();
            $table->string('title')->nullable();
            $table->longText('note')->nullable();
            $table->float('mark')->nullable();
            $table->integer('type')->comment('1: manual,:2 automated');
            $table->integer('category')->comment('1:assignment,2:test,3:exam');
            $table->integer('status')->default(1)->comment('0:deleted,1:active,3:closed,4:auto-closed');
            $table->string('start_date',20)->nullable();
            $table->string('end_date',20)->nullable(); 
            $table->string('start_time',20)->nullable();
            $table->string('end_time',20)->nullable();
            $table->string('teacher_pid')->nullable();
            $table->string('subject_pid')->nullable();
            $table->integer('acsess')->default(0)->comment('0:private, 1:public');
            $table->integer('recordable')->default(0)->comment('0:no, 1:yes');
            $table->string('ca_pid')->nullable()->comment('if recoredable, mapp to which Assessment type');
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
        Schema::dropIfExists('question_banks');
    }
};
