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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();

            $table->date('date');
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('body');
            $table->text('excerpt');
            $table->string('student_nik');
            $table->unsignedBigInteger('category_id');
            $table->string("image")->nullable();
            $table->enum("place", ["out", "in"]);
            $table->enum("status", ["0", "1", "2"]);
            $table->enum("privacy", ["anonymous", "public"]);

            $table->foreign("student_nik")
                ->references("student_nik")
                ->on("students")
                ->onDelete("cascade")
                ->onUpdate("cascade");

            $table->foreign("category_id")
                ->references("id")
                ->on("categories")
                ->onDelete("restrict");

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
        Schema::dropIfExists('complaints');
    }
};
