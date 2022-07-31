<?php

namespace App\Services;
use App\Models\Seance;

class SeanceService
{
     /**
     * Display a listing of seances .
     */
    public function index()
    {
        $list_seances=Seance::all();
        return response()->json($list_seances);
    }

     /**
     * Display the specified seances for a movie.
     */
    public function showByMovie($idMovie)
    {
    }

}