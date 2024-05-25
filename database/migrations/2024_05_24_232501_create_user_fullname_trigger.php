<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // on insert 
        DB::unprepared('
            CREATE TRIGGER before_user_detail_insert
            BEFORE INSERT ON user_details FOR EACH ROW
            BEGIN
            SET NEW.fullname = CONCAT(NEW.lastname, " ", NEW.firstname, " ", NEW.othername);
            END
            ');
        // on update 
        DB::unprepared('
            CREATE TRIGGER update_user_details_fullname
            BEFORE UPDATE ON user_details
            FOR EACH ROW
            BEGIN
            IF NEW.lastname != OLD.lastname OR NEW.firstname != OLD.firstname OR NEW.othername != OLD.othername THEN
            SET NEW.fullname = CONCAT(NEW.lastname, " ", NEW.firstname, " ", NEW.othername);
            END IF;
            END
            ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_fullname_trigger');
    }
};
