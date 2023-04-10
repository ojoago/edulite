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
        Schema::create('student_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('student_pid');
            $table->string('item_amount_pid')->comment('a particular fee item');
            $table->string('pid')->unique();
            $table->float('amount')->default(0);// this is it
            $table->string('param_pid');
            $table->integer('status')->comment('0 not paid,1 paid, 2 processing')->default(0);
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
        Schema::dropIfExists('student_invoices');
    }
};
