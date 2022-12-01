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
        Schema::create('student_invoice_payment_records', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->float('amount')->default(0);
            $table->string('generated_by')->nullable();
            $table->string('invoice_pid');
            $table->string('received_by')->nullable();
            $table->string('channel')->nullable();
            $table->string('code')->nullable();
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
        Schema::dropIfExists('student_invoice_payment_records');
    }
};
