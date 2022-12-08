<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Demande_imm;
use App\Http\Controllers\ParcelleController;
use App\Http\Controllers\VillageController;
use App\Http\Controllers\ProprietaireController;
use Illuminate\Support\Facades\Auth;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});


// Auth Router
Route::post('/v1/login', [AuthController::class, 'login']);
Route::delete('/v1/logout', [AuthController::class, 'logout']);
Route::post('/v1/register', [AuthController::class, 'register']);

    
// Users Router
Route::get('/v1/getAgents', [UserController::class, 'getAgents']);
Route::get('/v1/getAgent/{id}', [UserController::class, 'getAgent']);
Route::delete('/v1/deleteAgent/{id}', [UserController::class, 'deleteAgent']);   
Route::put('/v1/updateAgent/{id}', [UserController::class, 'updateAgent']);


// Parcelles Router
Route::post('/v1/newParcelle', [ParcelleController::class, 'newParcelle']);
Route::get('/v1/getParcelles', [ParcelleController::class, 'getParcelles']);
Route::get('/v1/getParcelle/{id}', [ParcelleController::class, 'getSpecificParcelle']);
Route::delete('/v1/deleteParcelle/{id}', [ParcelleController::class, 'deleteParcelle']);   
Route::put('/v1/updateParcelle/{id}', [ParcelleController::class, 'updateParcelle']);


// Villages Router
Route::post('/v1/newVillage', [VillageController::class, 'newVillage']);
Route::get('/v1/getVillages', [VillageController::class, 'getVillages']);
Route::get('/v1/getVillage/{id}', [VillageController::class, 'getSpecificVillage']);
Route::delete('/v1/deleteVillage/{id}', [VillageController::class, 'deleteVillage']);
Route::put('/v1/updateVillage/{id}', [VillageController::class, 'updateVillage']);

// proprietaires Router
Route::post('/v1/newProprietaire', [ProprietaireController::class, 'newProprietaire']);
Route::get('/v1/getProprietaires', [ProprietaireController::class, 'getProprietaires']);
Route::get('/v1/getProprietaire/{id}', [ProprietaireController::class, 'getSpecificProprietaire']);
Route::delete('/v1/deleteProprietaire/{id}', [ProprietaireController::class, 'deleteProprietaire']);   
Route::post('/v1/updateProprietaire/{id}', [ProprietaireController::class, 'updateProprietaire']);


//Update User Profile
Route::put('/v1/updateProfile/{id}', [UserController::class, 'updateProfile']);
Route::get('/v1/getProfile/{id}', [UserController::class, 'getProfile']);
Route::get('/v1/generateDemande/{id}', [Demande_imm::class, 'generateDemande']);

Route::get('/v1/sessionStatus', function() {
    return ['user' => Auth::check() ? 'nice' : null];
});



