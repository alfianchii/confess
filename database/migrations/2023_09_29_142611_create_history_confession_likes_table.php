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
        Schema::create('history_confession_likes', function (Blueprint $table) {
            $table->id("id_confession_like");

            $table->unsignedBigInteger("id_confession");
            $table->unsignedBigInteger("id_user");

            $table->foreign("id_confession")
                ->references("id_confession")
                ->on("rec_confessions");
            $table->foreign("id_user")
                ->references("id_user")
                ->on("mst_users");

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
        Schema::dropIfExists('history_confession_likes');
    }
};
