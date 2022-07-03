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
        Schema::create('student_class_histories', function (Blueprint $table) {
            $table->id();
            $table->string('student_pid');
            $table->text('note');
            $table->integer('code')->default(1)->comment('1 = promoted, 0 repeated class');
            $table->string('session')->comment('academic session');
            $table->string('school_category')->comment('category id');
            $table->string('school_class')->comment('');
            $table->string('class_arm')->comment('class arm');
            $table->string('school_pid')->nullable();
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
        Schema::dropIfExists('student_class_histories');
    }
};
