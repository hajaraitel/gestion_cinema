<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class FilmController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_film=Film::all();
        return response()->json($list_film);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator  = Validator::make($request->all(), [
            'titre' => ['required', 'max:30', 'string'],
            'annee_sortie' => ['required','integer'],
            'realisateur' => ['required', 'max:30', 'string'],
            'acteurs' => ['required', 'max:60', 'string'],
            'duree' => ['required', 'max:10', 'string'],
            'genre' => ['required', 'max:30', 'string'],
            'langue' => ['required', 'max:20', 'string'],
            'description' => ['required', 'max:200', 'string'],
            
            'titre.required'=>'le titre est obligatoire',
            'annee_sortie.required'=>'annee_sortie est obligatoire',
            'realisateur.required'=>'le realissateur est obligatoire',
            'acteurs.required'=>'les acteurs sont obligatoire',
            'duree.required'=>'la durée est obligatoire',
            'genre.required'=>'le genre de film est obligatoire',
            'langue.required'=>'la langue est obligatoire',
            'description.required'=>'la description est obligatoire'
        
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }

        $validated = $validator->validated();  
        $film = new Film();
        $img_url = '/images/films/';
        $img = $img_url.$request->affiche;
        $film->titre =  $request->titre;
        $film->annee_sortie = $request->annee_sortie;
        $film->realisateur = $request->realisateur;
        $film->acteurs = $request->acteurs;
        $film->duree = $request->duree;
        $film->affiche = $img;
        $film->genre = $request->genre;
        $film->langue = $request->langue;
        $film->description = $request->description;
        $film->save();   
        return response()->json(['film'=>$film],200);

        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Film::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $idFilm)
    {
        $validator  = Validator::make($request->all(), [
            'titre' => ['required', 'max:30', 'string'],
            'annee_sortie' => ['required','integer'],
            'realisateur' => ['required', 'max:30', 'string'],
            'acteurs' => ['required', 'max:60', 'string'],
            'duree' => ['required', 'max:10', 'string'],
            'genre' => ['required', 'max:30', 'string'],
            'langue' => ['required', 'max:20', 'string'],
            'description' => ['required', 'max:200', 'string'],
            
            'titre.required'=>'le titre est obligatoire',
            'annee_sortie.required'=>'annee_sortie est obligatoire',
            'realisateur.required'=>'le realissateur est obligatoire',
            'acteurs.required'=>'les acteurs sont obligatoire',
            'duree.required'=>'la durée est obligatoire',
            'genre.required'=>'le genre de film est obligatoire',
            'langue.required'=>'la langue est obligatoire',
            'description.required'=>'la description est obligatoire'
        
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }
        $validated = $validator->validated();  

        $film = Film::find($idFilm);
       if($film)
        {
           if($film->affiche != $request->affiche)
            {
                
                $img_url = '/images/films/';
                $img=$img_url.$request->affiche;
                $film->affiche = $img;
            }
           else{
                $film->affiche =  $request->affiche;
            }    
            $film->titre =  $request->titre;
            $film->annee_sortie = $request->annee_sortie;
            $film->realisateur = $request->realisateur;
            $film->acteurs = $request->acteurs;
            $film->duree = $request->duree;
            $film->genre = $request->genre;
            $film->langue = $request->langue;
            $film->description = $request->description;
            $film->save();   
            return response()->json(['film'=>$film],200);
            
        }
        return "error";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idFilm)
    {
        $film=Film::find($idFilm);
        if($film)
        {
            $film->delete();
            return response()->json($film);
        }
        return "erreur";
    }

    public function countFilm()
    {
        $films = Film::all();

        $allFilms = [
            'films' => $films,
            'films_count' => $films->count()
        ];

        return $allFilms;
    }
}
