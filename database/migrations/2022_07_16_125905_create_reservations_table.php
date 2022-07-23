<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReservationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('reservations', function (Blueprint $table) {
            $table->bigIncrements('idReservation');
            $table->unsignedBigInteger('idSeance');
            $table->unsignedBigInteger('idUser');
            $table->integer('nb_adult');
            $table->integer('nb_enfant');
            $table->float('prix_total');
            $table->date('date_reservation');
            $table->boolean('est_annule')->default(false);
            $table->timestamps();

            $table->foreign('idSeance')
                ->references('idSeance')
                ->on('seances')
                ->onUpdate('cascade')
                ->onDelete('cascade');          

            $table->foreign('idUser')
                ->references('idUser')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->index(['est_annule', 'date_reservation'],'reservation_index');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('reservations');
    }
}
