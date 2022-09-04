<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalleController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\FilmController;
use App\Http\Controllers\ReservationController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CommentaireController;
use App\Http\Controllers\MessageController;
use App\Http\Controllers\SeanceController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
//public routes
Route::post('/login',[AuthController::class,'login']);
Route::post('/register',[AuthController::class,'register']);

//protected routes
Route::group(['middleware'=>['auth:sanctum']],function(){
    //Route::post('/logout',[AuthController::class,'logout']);
    //Route::apiResource('film', FilmController::class);
    //Route::apiResource('salle', SalleController::class);
    //Route::apiResource('reservation', ReservationController::class);
    //Route::apiResource('user', UserController::class);
    //Route::apiResource('seance', SeanceController::class);
    //Route::apiResource('commentaire', CommentaireController::class);
    //Route::apiResource('message', MessageController::class);
    
}
);

//just pour le test ces route doivent etre protege !
Route::apiResource('salle', SalleController::class);

Route::apiResource('reservation', ReservationController::class);
Route::get('countUser', [UserController::class,'countUser']);
Route::get('countFilm', [FilmController::class,'countFilm']);
Route::get('countReservation', [ReservationController::class,'countReservation']);
Route::get('sumReservation', [ReservationController::class,'sumReservation']);
Route::apiResource('user', UserController::class);
Route::put('users/{id}',[UserController::class,'updateRole']);

