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
        Schema::table('student_class_results', function (Blueprint $table) {
            $table->string('teacher_comment_on',20)->nullable();
            $table->string('principal_comment_on',20)->nullable();
            $table->string('portal_comment_on',20)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('student_class_results');
    }
};
