<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddUniqueToSeancesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->unique(array('date_seance', 'horaire','idSalle'),'seance_index_unique_2');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('seances', function (Blueprint $table) {
            $table->dropIndex('seance_index_unique_2');

        });
    }
}
