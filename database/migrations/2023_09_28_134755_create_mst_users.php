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
        Schema::create('mst_users', function (Blueprint $table) {
            $table->id("id_user");

            $table->index("nik");

            $table->string('nik', 16)->unique();
            $table->string('full_name', 50);
            $table->string('username')->unique();
            $table->enum('gender', ["L", "P"]);
            $table->string('email')->unique()->nullable();
            $table->string("profile_picture")->nullable();
            $table->string('password');
            $table->enum('flag_active', ["Y", "N"]);
            $table->timestamp('last_login_at')->nullable();

            $table->rememberToken();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
            $table->timestamps();
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
        Schema::dropIfExists('mst_users');
    }
};
