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
    //principal defined comments
    public function up()
    {
        Schema::table('principal_comments', function (Blueprint $table) {
            $table->string('category_pid');
            $table->string('comment')->change();
            $table->renameColumn('staff_pid', 'principal_pid')->comment('principal pid');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('principal_comments');
    }
};
