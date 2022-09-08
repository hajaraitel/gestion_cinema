<?php

namespace App\Services;
use App\Models\Film;

class FilmService
{
     /**
     * Display a listing of films .
     */
    public function index()
    {
        $list_films=Film::all();
        return response()->json($list_films);
    }

     /**
     * Display the specified film.
     */
    public function show($id)
    {
        return response()->json(Film::find($id));
    }

}