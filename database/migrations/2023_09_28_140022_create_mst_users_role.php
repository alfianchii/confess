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
        Schema::create('mst_users_role', function (Blueprint $table) {
            $table->id("id_user_role");

            $table->unsignedBigInteger('id_user')->unique();
            $table->unsignedBigInteger('id_role');
            $table->enum('flag_active', ["Y", "N"]);

            $table->foreign("id_user")
                ->references("id_user")
                ->on("mst_users")
                ->onDelete("cascade")
                ->onUpdate("NO ACTION");

            $table->foreign("id_role")
                ->references("id_role")
                ->on("mst_roles")
                ->onDelete("NO ACTION")
                ->onUpdate("NO ACTION");

            $table->timestamps();
            $table->string('updated_by')->nullable();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_userRoles');
    }
};
