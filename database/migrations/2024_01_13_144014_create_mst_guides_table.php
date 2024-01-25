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
        Schema::create('mst_guides', function (Blueprint $table) {
            $table->id("id_guide");

            $table->integer('id_guide_parent');
            $table->string('nav_title');
            $table->string('title')->nullable();
            $table->string('slug')->unique();
            $table->string('url')->nullable();
            $table->longText('body')->nullable();
            $table->integer('reading_time')->nullable();
            $table->enum('flag_active', ["Y", "N"]);

            $table->timestamps();
            $table->string('created_by');
            $table->string('updated_by')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mst_guides');
    }
};
