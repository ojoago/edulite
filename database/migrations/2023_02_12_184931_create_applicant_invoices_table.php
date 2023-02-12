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
        Schema::create('applicant_invoices, function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('applicant_pid');
            $table->string('pid')->unique();
            $table->float('amount')->default(0);
            $table->integer('status')->comment('0 not paid,1 paid, 2 processing')->default(0);
            $table->string('applicant_pid');
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
        Schema::dropIfExists('applicant_invoices');
    }
};
