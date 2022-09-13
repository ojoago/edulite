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
            $table->string('role')->nullable()->comment('actor');
            $table->string('staff_id')->unique()->comment('staff id card number');
            $table->string('status')->default(1)->comment('1 = active, 0 disbled, 3 sacked,4 left the school');
            $table->text('access')->nullable()->comment('role access');
            $table->text('stamp')->nullable()->comment('official stampd');
            $table->text('signature')->nullable()->comment('officail signature');
            $table->text('passport')->nullable()->comment('profile pix');
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
