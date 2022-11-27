<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePeopleTapMenuTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('people_tap_menu', function (Blueprint $table) {
            $table->id();
            $table->string('nik');
            $table->datetime('absen_a_time_in')->nullable();
            $table->datetime('absen_b_time_in')->nullable();
            $table->datetime('absen_c_time_in')->nullable();
            $table->char('status_tap_in')->comment('1=first_tap, 2=second_tap, 3=third_tap')->nullable();
            $table->datetime('absen_a_time_out')->nullable();
            $table->datetime('absen_b_time_out')->nullable();
            $table->datetime('absen_c_time_out')->nullable();
            $table->char('status_tap_out')->comment('1=first_tap, 2=second_tap, 3=third_tap')->nullable();
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
        Schema::dropIfExists('people_tap_menu');
    }
}
