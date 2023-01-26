<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHistoryInOutTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('history_in_out', function (Blueprint $table) {
            $table->id();
            $table->integer('id_people_tap_menu');
            $table->datetime('time_in')->nullable();
            $table->datetime('time_out')->nullable();
            $table->datetime('duration')->nullable();
            $table->string('type_room');
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
        Schema::dropIfExists('history_in_out');
    }
}
