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
        Schema::create('history_logins', function (Blueprint $table) {
            $table->id("id_history_login");

            $table->string('username');
            $table->enum("attempt_result", ["Y", "N"]);
            $table->string("operating_system");
            $table->string("remote_address");
            $table->text("user_agent");
            $table->text("browser");

            $table->timestamps();
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
        Schema::dropIfExists('history_logins');
    }
};
