<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        // ---------------------------------
        // MYSQL
        // User's role
        DB::unprepared('
            CREATE TRIGGER TR_user_role_AI
            AFTER INSERT
            ON mst_users_role FOR EACH ROW
            BEGIN
                IF NEW.id_role = 3 THEN
                    INSERT INTO dt_students (id_user)
                    VALUES (NEW.id_user);
                ELSEIF NEW.id_role = 1 OR NEW.id_role = 2 THEN
                    INSERT INTO dt_officers (id_user)
                    VALUES (NEW.id_user);
                END IF;
            END;
        ');

        // Deactivating user
        DB::unprepared("
            CREATE TRIGGER TR_deactivating_user_AU
            AFTER UPDATE
            ON mst_users FOR EACH ROW
            BEGIN
                IF NEW.flag_active = 'N' THEN
                    UPDATE mst_users_role SET flag_active = 'N' WHERE id_user = NEW.id_user;

                    IF NEW.id_user IN (SELECT id_user FROM dt_students) THEN
                        UPDATE dt_students SET flag_active = 'N' WHERE id_user = NEW.id_user;
                    ELSEIF NEW.id_user IN (SELECT id_user FROM dt_officers) THEN
                        UPDATE dt_officers SET flag_active = 'N' WHERE id_user = NEW.id_user;
                    END IF;
                END IF;
            END;
        ");

        // Activating user
        DB::unprepared("
            CREATE TRIGGER TR_activating_user_AU
            AFTER UPDATE
            ON mst_users FOR EACH ROW
            BEGIN
                IF NEW.flag_active = 'Y' THEN
                    UPDATE mst_users_role SET flag_active = 'Y' WHERE id_user = NEW.id_user;

                    IF NEW.id_user IN (SELECT id_User FROM dt_students) THEN
                        UPDATE dt_students SET flag_active = 'Y' WHERE id_user = NEW.id_user;
                    ELSEIF NEW.id_user IN (SELECT id_user FROM dt_officers) THEN
                        UPDATE dt_officers SET flag_active = 'Y' WHERE id_user = NEW.id_user;
                    END IF;
                END IF;
            END;
        ");

        // ---------------------------------
        // POSTGRESQL
        // // User's role
        // DB::unprepared("
        //     CREATE OR REPLACE FUNCTION user_role() 
        //     RETURNS TRIGGER AS $$
        //     BEGIN
        //         IF NEW.id_role = 3 THEN
        //             INSERT INTO dt_students (id_user, flag_active)
        //             VALUES (NEW.id_user, NEW.flag_active);
        //         ELSEIF NEW.id_role = 1 OR NEW.id_role = 2 THEN
        //             INSERT INTO dt_officers (id_user, flag_active)
        //             VALUES (NEW.id_user, NEW.flag_active);
        //         END IF;
        //         RAISE NOTICE 'Trigger fired!';
        //         RETURN NEW; -- Don't forget to return the NEW row at the end
        //     END;
        //     $$ LANGUAGE plpgsql;

        //     CREATE TRIGGER TR_user_role_AI
        //     AFTER INSERT 
        //     ON mst_users_role FOR EACH ROW
        //     EXECUTE FUNCTION user_role();
        // ");

        // // Non-active user
        // DB::unprepared("
        //     CREATE OR REPLACE FUNCTION non_active_user() 
        //     RETURNS TRIGGER AS $$
        //     BEGIN
        //         IF NEW.flag_active = 'N' THEN
        //             UPDATE mst_users_role SET flag_active = 'N' WHERE id_user = NEW.id_user;

        //             IF NEW.id_user IN (SELECT id_user FROM dt_students) THEN
        //                 UPDATE dt_students SET flag_active = 'N' WHERE id_user = NEW.id_user;
        //             ELSEIF NEW.id_user IN (SELECT id_user FROM dt_officers) THEN
        //                 UPDATE dt_officers SET flag_active = 'N' WHERE id_user = NEW.id_user;
        //             END IF;
        //         END IF;
        //         RAISE NOTICE 'Trigger fired!';
        //         RETURN NEW; -- Don't forget to return the NEW row at the end
        //     END;
        //     $$ LANGUAGE plpgsql;

        //     CREATE TRIGGER TR_non_active_user_AU
        //     AFTER UPDATE 
        //     ON mst_users FOR EACH ROW
        //     EXECUTE FUNCTION non_active_user();
        // ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        DB::unprepared('DROP TRIGGER IF EXISTS userRole');
    }
};
