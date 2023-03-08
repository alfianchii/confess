<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
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
        DB::unprepared('
            CREATE TRIGGER tr_add_user 
            AFTER INSERT
            ON users FOR EACH ROW
            BEGIN
                IF NEW.level = "student" THEN
                    INSERT INTO students (student_nik)
                    VALUES (NEW.nik);
                ELSEIF NEW.level = "officer" OR NEW.level = "admin" THEN
                    INSERT INTO officers (officer_nik)
                    VALUES (NEW.nik);
                END IF;
            END;
        ');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared("DROP TRIGGER tr_add_user");
    }
};
