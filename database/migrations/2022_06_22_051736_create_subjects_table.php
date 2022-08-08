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
        Schema::create('subjects', function (Blueprint $table) {
            $table->id();
            $table->string('subject');
            $table->string('description')->nullable();
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->string('status')->default(1)->comment('1 enable, 0 disable');
            $table->string('subject_type_pid')->comment('subject type pid');
            $table->string('category_pid')->comment('subject type pid');
            $table->string('staff_pid')->comment('staff pid');
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
        Schema::dropIfExists('subjects');
    }
};
