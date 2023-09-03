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
        Schema::table('student_invoice_payments', function (Blueprint $table) {
            $table->renameColumn('generated_by', 'paid_by');
            $table->string('role')->nullable();
            $table->string('mode')->default(1)->comment('1:online :2 direct,3 wallet');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        // Schema::dropIfExists('student_invoice_payments');
    }
};
