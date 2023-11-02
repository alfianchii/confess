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
        Schema::create('mst_confession_categories', function (Blueprint $table) {
            $table->id("id_confession_category");

            $table->string("category_name");
            $table->string("image")->nullable();
            $table->text('description');
            $table->string("slug")->unique();
            $table->enum('flag_active', ["Y", "N"]);

            $table->timestamps();
            $table->string('updated_by')->nullable();
            $table->string('created_by')->nullable();
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
        Schema::dropIfExists('mst_confession_categories');
    }
};
