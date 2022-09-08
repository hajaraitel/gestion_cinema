<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('seances', function (Blueprint $table) {
            $table->bigIncrements('idSeance');
            $table->unsignedBigInteger('idSalle');
            $table->unsignedBigInteger('idFilm');
            $table->date('date_seance');
            $table->time('horaire');
            $table->float('prix',5,2);
            $table->string('version',100);
            $table->timestamps();

            $table->foreign('idSalle')
                ->references('idSalle')
                ->on('salles')
                ->onUpdate('cascade')
                ->onDelete('cascade');          

            $table->foreign('idFilm')
                ->references('idFilm')
                ->on('films')
                ->onUpdate('cascade')
                ->onDelete('cascade');
            
            $table->unique(array('date_seance', 'horaire','idSalle','idFilm'),'seance_index_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('seances');
    }
}
