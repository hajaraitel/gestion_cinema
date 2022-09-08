<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFilmsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('films', function (Blueprint $table) {
            $table->bigIncrements('idFilm');
            $table->string('titre',255);
            $table->integer('annee_sortie')->nullable();
            $table->string('realisateur',100);
            $table->string('acteurs',255);
            $table->time('duree');
            $table->string('affiche',255);
            $table->string('genre',255);
            $table->string('langue',100)->nullable();
            $table->text('description')->nullable();
            $table->timestamps();
            $table->index(['titre', 'annee_sortie','langue','genre']);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('films');
    }
}
