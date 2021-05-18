<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetailsBillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('details_bills', function (Blueprint $table) {
            $table->bigIncrements('id')->nullable();
            $table->string('content')->nullable();
            $table->string('price')->nullable();
            $table->unsignedBigInteger('idReservation');
            $table->foreign('idReservation')->references('id')->on('reservations');
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
        Schema::dropIfExists('details_bills');
    }
}
