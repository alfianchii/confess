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
        Schema::create('rec_confessions', function (Blueprint $table) {
            $table->id("id_confession");

            $table->unsignedBigInteger("id_user");
            $table->date('date');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->text('excerpt');
            $table->unsignedBigInteger('assigned_to')->nullable();
            $table->unsignedBigInteger('id_confession_category');
            $table->string("image")->nullable();
            $table->enum("place", ["out", "in"]);
            $table->enum("status", ["unprocess", "process", "release", "close"]);
            $table->enum("privacy", ["anonymous", "public"]);

            $table->foreign("id_user")
                ->references("id_user")
                ->on("dt_students")
                ->onDelete("NO ACTION")
                ->onUpdate("NO ACTION");

            $table->foreign("assigned_to")
                ->references("id_user")
                ->on("dt_officers")
                ->onDelete("NO ACTION");

            $table->foreign("id_confession_category")
                ->references("id_confession_category")
                ->on("mst_confession_categories")
                ->onDelete("NO ACTION");

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
        Schema::dropIfExists('rec_confessions');
    }
};
