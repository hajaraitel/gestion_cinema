<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCommentairesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('commentaires', function (Blueprint $table) {
            $table->bigIncrements('idCommentaire');
            $table->unsignedBigInteger('idUser');
            $table->unsignedBigInteger('idFilm');
            $table->float('evaluation',3,1)->nullable();
            $table->text('commentaire');
            $table->timestamps();

            $table->foreign('idUser')
                ->references('idUser')
                ->on('users')
                ->onUpdate('cascade')
                ->onDelete('cascade');
                

            $table->foreign('idFilm')
                ->references('idFilm')
                ->on('films')
                ->onUpdate('cascade')
                ->onDelete('cascade');

            $table->unique(array('idUser', 'idFilm'),'commentaire_index_unique');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('commentaires');
    }
}
