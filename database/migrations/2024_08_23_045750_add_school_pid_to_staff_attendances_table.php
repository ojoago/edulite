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
        Schema::table('staff_attendances', function (Blueprint $table) {
            $table->string('school_pid')->after('id');
            $table->string('path')->after('status')->nullable();
            $table->string('platform')->after('path')->nullable();
            $table->string('device')->after('platform')->nullable();
            $table->string('browser')->after('device')->nullable();
            $table->string('address')->after('browser')->nullable();
            $table->json('cordinates')->after('address')->nullable();
            $table->string('clock_in',20)->after('cordinates');
            $table->string('clock_out',20)->after('clock_in')->nullable();
            $table->boolean('late')->after('clock_out')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropColumns('school_pid');
    }
};
