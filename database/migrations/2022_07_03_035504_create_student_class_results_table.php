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
        Schema::create('student_class_results', function (Blueprint $table) {
            $table->id();
            $table->string('class_param_pid');
            $table->string('school_pid');
            $table->string('student_pid');
            $table->float('total')->nullable();
            $table->float('status')->default(0)->comment('1 paid, 0 not paid');
            $table->text('class_teacher_comment')->nullable();
            $table->text('principal_comment')->nullable();
            $table->text('portal_comment')->nullable();
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
        Schema::dropIfExists('student_class_results');
    }
};
