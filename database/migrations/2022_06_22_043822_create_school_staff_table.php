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
        Schema::create('school_staff', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid');
            $table->string('user_pid');
            $table->string('pid')->unique();
            $table->string('role_id')->comment('actor');
            $table->string('staff_id')->nullable()->comment('staff id card number');
            $table->string('status')->default(1)->comment('1 = active, 0 disbled');
            $table->string('access')->nullable()->comment('role access');
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
        Schema::dropIfExists('staff');
    }
};
