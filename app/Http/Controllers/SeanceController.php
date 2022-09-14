<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use App\Models\Seance;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class SeanceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $list_seance= DB::table('seances')
        ->join ('salles','seances.idSalle', '=' , "salles.idSalle")
        ->join ('films','seances.idFilm', '=' , "films.idFilm")
        ->select('seances.*','salles.nom' , 'films.titre', 'seances.date_seance' , 'seances.horaire', 'seances.prix' , 'seances.version')
        ->get();
         return response()->json($list_seance);
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
           
            'version' => ['required', 'max:30', 'string']],
            [
            'date_seance.required'=>'la date de seance est obligatoire',
            'horaire.required'=>'horaire est obligatoire',
            'prix.required'=>'le prix est obligatoire',
            'version.required'=>'la version est obligatoire', 
        
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }

        $validated = $validator->validated();  
        $seance = new Seance();
        $seance->idSalle =  $request->idSalle;
        $seance->idFilm = $request->idFilm;
        $seance->date_seance = $request->date_seance;
        $seance->horaire = $request->horaire;
        $seance->prix = $request->prix;
        $seance->version = $request->version;
        $seance->save();   
        return response()->json(['seance'=>$seance],200);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(Seance::find($id));
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
    public function update(Request $request, $idSeance)
    {
        $validator  = Validator::make($request->all(), [
         
            'version' => ['required', 'max:30', 'string']],
            [
            'date_seance.required'=>'la date de seance est obligatoire',
            'horaire.required'=>'horaire est obligatoire',
            'prix.required'=>'le prix est obligatoire',
            'version.required'=>'la version est obligatoire', 
        
        ]);
        if ($validator->fails()) {    
            return response()->json($validator->messages()->all(), 400);
        }

        $validated = $validator->validated();  
        $seance = Seance::find($idSeance);
        if($seance)
        {
            $seance->idSalle =  $request->idSalle;
            $seance->idFilm = $request->idFilm;
            $seance->date_seance = $request->date_seance;
            $seance->horaire = $request->horaire;
            $seance->prix = $request->prix;
            $seance->version = $request->version;
            $seance->save();
            return response()->json(['seance'=>$seance],200);
        }
        return "erreur";
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($idSeance)
    {
        $seance=Seance::find($idSeance);
        if($seance)
        {
            $seance->delete();
            return response()->json($seance);
        }
        return "erreur";
    }
}
