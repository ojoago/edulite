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
        Schema::table('result_configs', function (Blueprint $table) {
            $table->string('base_dir')->default('school.student.result.')->nullable();
            $table->string('sub_dir')->default('termly-result.')->nullable();
            $table->string('file_name')->default('student-report-card')->nullable();
            $table->tinyInteger('show_chart')->default(1)->nullable();
            $table->json('settings')->nullable();
            $table->string('student_name')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('result_configs');
    }
};
