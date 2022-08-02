<?php

namespace App\Services;
use App\Models\Seance;
use Illuminate\Support\Facades\DB;

class SeanceService
{
     /**
     * Display a listing of seances .
     */
    public function index()
    {
        $list_seances = DB::table('seances')
            ->Join('salles', 'salles.idSalle', '=', 'seances.idSalle')
            ->Join('films', 'films.idFilm', '=', 'seances.idFilm')
            ->select('seances.*', 'salles.nom as nom_salle','salles.capacite','films.titre')
            ->get();
        
        return response()->json($list_seances);
    }

     /**
     * Display the specified seances for a movie.
     */
    public function showByMovie($idMovie)
    {
    }

}