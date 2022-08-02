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
use App\Services\FilmService;
use App\Services\ReservationService;
use App\Services\SeanceService;

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
    Route::get('getRole',[AuthController::class,'getRole']);
    Route::apiResource('film', FilmController::class);
    Route::apiResource('salle', SalleController::class);
    Route::apiResource('reservation', ReservationController::class);
    Route::apiResource('user', UserController::class);
    Route::apiResource('seance', SeanceController::class);
    Route::apiResource('commentaire', CommentaireController::class);
    Route::apiResource('message', MessageController::class);
    //
    Route::get('/films/{film}',[FilmService::class,'show']);
    Route::get('/films',[FilmService::class,'index']);
    //
    Route::get('/reservations/{id}',[ReservationService::class,'show']);
    Route::get('/reservations/user/{idUser}',[ReservationService::class,'showUserReservation']);
    //
    Route::get('/seances/film/{idFilm}',[SeanceService::class,'showByMovie']);
    Route::get('/seances',[SeanceService::class,'index']);
    //
    Route::put('/userRole/{user}',[UserController::class,'updateRole']);
    //
    Route::get('/availability/{idSeance}',[SeanceService::class,'seance_remplie']);
}
);

//just pour le test ces route doivent etre protege !
//Route::apiResource('salle', SalleController::class);
