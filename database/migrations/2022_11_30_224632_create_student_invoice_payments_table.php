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
        Schema::create('student_invoice_payments', function (Blueprint $table) {
            $table->id();
            $table->string('school_pid')->nullable();
            $table->string('pid')->unique();
            $table->string('invoice_number')->unique();
            $table->float('total')->default(0);
            $table->float('amount_paid')->default(0);
            $table->integer('status')->default(0)->comment('0 not paid, 1 paid, 2 incompleted');
            $table->string('generated_by')->nullable();
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
        Schema::dropIfExists('student_invoice_payments');
    }
};
