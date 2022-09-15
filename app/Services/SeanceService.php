<?php

namespace App\Services;
use App\Models\Seance;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        
        foreach( $list_seances as $seance)
        {
             
            $seance->is_full = $this->seance_remplie($seance->idSeance);
        }
        
        return response()->json($list_seances);
         
    }

    /**
     * show seance detail
     */
    public function showBySeance($idSeance)
    {
        $seance = DB::table('seances')
            ->Join('salles', 'salles.idSalle', '=', 'seances.idSalle')
            ->Join('films', 'films.idFilm', '=', 'seances.idFilm')
            ->select('seances.*', 'salles.nom as nom_salle','salles.capacite','films.titre')
            ->where('seances.idSeance', '=', $idSeance)
            ->get()->first();
        
        return response()->json($seance);
    }

     /**
     * Display the specified seances for a movie.
     */
    public function showByMovie($idMovie)
    {
        $list_seances = DB::table('seances')
            ->Join('salles', 'salles.idSalle', '=', 'seances.idSalle')
            ->Join('films', 'films.idFilm', '=', 'seances.idFilm')
            ->select('seances.*', 'salles.nom as nom_salle','salles.capacite','films.titre')
            ->where('films.idFilm', '=', $idMovie)
            ->get();
        
        foreach( $list_seances as $seance)
        {
             
            $seance->is_full = $this->seance_remplie($seance->idSeance);
        }

        return response()->json($list_seances);
    }

    /**
     * get total confirmed reservations
     */
    public function total_reservations_seance($idSeance)
    {
        $nb_res = DB::table('reservations')
        ->selectRaw('sum(COALESCE(nb_adult,0)+COALESCE(nb_enfant,0)) as nb_reservation')
        ->where('reservations.idSeance', '=', $idSeance)
        ->where('reservations.est_annule', '=', 'false')
        ->get()->first();


        return $nb_res->nb_reservation;
    }

    /**
     * get capacity of salle of seance
     */
    public function cap_salle_seance($idSeance)
    {
        $cap = DB::table('seances')
            ->Join('salles', 'salles.idSalle', '=', 'seances.idSalle')
            ->select('salles.capacite')
            ->where('seances.idSeance', '=', $idSeance)
            ->get()->first();
        
        return $cap->capacite;
    }

    /**
     * compare the salle capacity with the total of reservations
     */
    public function seance_remplie($idSeance)
    {
        $cap = $this->cap_salle_seance($idSeance);
        $total_res = $this->total_reservations_seance($idSeance);
       
        return $total_res >= $cap;

    
    }


}