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
        Schema::create('responses', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger("complaint_id");
            $table->text('body');
            $table->string("officer_nik");

            $table->foreign("complaint_id")
                ->references("id")
                ->on("complaints")
                ->onDelete("cascade")
                ->onUpdate("cascade");
            $table->foreign("officer_nik")
                ->references("officer_nik")
                ->on("officers")
                ->onDelete("cascade")
                ->onUpdate("cascade");

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
        Schema::dropIfExists('responses');
    }
};