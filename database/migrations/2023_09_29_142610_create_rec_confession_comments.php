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
        Schema::create('rec_confession_comments', function (Blueprint $table) {
            $table->id("id_confession_comment");

            $table->unsignedBigInteger("id_confession");
            $table->unsignedBigInteger("id_user");

            $table->text('comment');
            $table->enum("privacy", ["anonymous", "public"]);
            $table->string("attachment_file", 255)->nullable();

            $table->foreign("id_confession")
                ->references("id_confession")
                ->on("rec_confessions")
                ->onDelete("NO ACTION")
                ->onUpdate("NO ACTION");
            $table->foreign("id_user")
                ->references("id_user")
                ->on("mst_users")
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
        Schema::dropIfExists('rec_confession_comments');
    }
};
