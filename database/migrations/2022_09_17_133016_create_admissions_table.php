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
        Schema::create('admissions', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('pid')->unique();
            $table->string('firstname');
            $table->string('lastname');
            $table->string('othername')->nullable();
            $table->string('username')->nullable();
            $table->string('fullname')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('dob')->nullable();
            $table->string('gender')->nullable();
            $table->string('religion')->nullable();
            $table->text('passport')->nullable();
            $table->text('address')->nullable();
            $table->string('admission_number');
            $table->string('gsm')->nullable();
            $table->string('email')->nullable();
            $table->string('status')->default(1)->comment('1 applied, 2 given, 3 denied');
            $table->string('type')->default(1)->comment('1 day, 2 boarding');
            $table->string('session_pid')->nullable();
            $table->string('category_pid')->nullable();
            $table->string('class_pid')->nullable();
            $table->string('arm_pid')->nullable();
            $table->string('term_pid')->nullable();
            $table->string('staff_pid')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('contact_gsm')->nullable();
            $table->string('contact_email')->nullable();
            $table->string('parent_pid')->nullable();
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
        Schema::dropIfExists('adminssions');
    }
};
