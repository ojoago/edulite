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
    //form master defined comment
    public function up()
    {
        Schema::table('form_master_comments', function (Blueprint $table) {
            $table->text('comment')->change();
            $table->renameColumn('staff_pid','teacher_pid')->comment('form master pid');
            $table->string('category_pid')->comment('category');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('form_master_comments');
    }
};
